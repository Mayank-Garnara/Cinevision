<?php
include("../../common/connection/connection.php");

// Helper function to sanitize input
function sanitize($data) {
    return trim($data);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnRegester'])) {

    // Sanitize inputs
    $name     = sanitize($_POST['name']);
    $email    = sanitize($_POST['email']);
    $mobile   = sanitize($_POST['mobile']);
    $password = sanitize($_POST['password']);
    $dob      = sanitize($_POST['dob']);
    $gender   = isset($_POST['gender']) ? intval($_POST['gender']) : -1;

    // Server-side validations
    $errors = [];

    // Validate name
    if (empty($name) || strlen($name) < 2) {
        $errors[] = "Please enter a valid name.";
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Check for existing email
    $stmt = $pdo->prepare("SELECT id FROM user WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $errors[] = "This email is already registered.";
    }

    // Validate mobile
    if (!preg_match("/^[0-9]{10}$/", $mobile)) {
        $errors[] = "Enter a valid 10-digit mobile number.";
    }

    // Validate password
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    // Validate DOB
    if (empty($dob)) {
        $errors[] = "Please select a valid Date of Birth.";
    }

    // Validate gender
    if (!in_array($gender, [0, 1, 2])) {
        $errors[] = "Please select your gender.";
    }

    if (!empty($errors)) {
        foreach ($errors as $err) {
            echo "<script>alert('$err');</script>";
        }
        echo "<script>window.history.back();</script>";
        exit();
    }

    // Hash the password
    $hashedPassword = md5($password);

    // Insert into database using PDO
    try {
        $insert = $pdo->prepare("INSERT INTO user (name, email, mobile, password, dob, gender)
                                 VALUES (?, ?, ?, ?, ?, ?)");
        $insert->execute([$name, $email, $mobile, $hashedPassword, $dob, $gender]);

        echo "<script>alert('Registration successful!'); window.location.href='../log-in.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Database Error: " . $e->getMessage() . "'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Invalid request'); window.location.href='../index.php';</script>";
}
?>