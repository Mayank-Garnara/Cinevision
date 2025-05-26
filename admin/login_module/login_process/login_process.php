<?php
session_start();
if (isset($_POST["email"]) && isset($_POST["password"])) {

    $user_name = $_POST['email'];
    $password = md5($_POST['password']);
    
    if (strlen(trim($_POST['password'])) > 5) {

        include '../../../common/connection/connection.php';
        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            // Query the database
            $sql = "SELECT * FROM admin WHERE email = :email OR phone = :phone limit 1 ";
            $stmt = $pdo->prepare($sql);

            $stmt->execute(
                [
                    'email' => $user_name,
                    'phone' => $user_name
                ]
            );
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify password
            if ($user && $user['password'] == $password) {
                // Password is correct, set session
                $_SESSION['admin_data'] = $user;
                header('location:../../dashboard_module/index.php');
            } else {
                // Invalid credentials
                $_SESSION['stateManage_userId'] = $user_name;
                $_SESSION['passworderror'] = 'Invalid username or password.';
                header("location:../");
            }
        }
    } else {
        $_SESSION['stateManage_userId'] = $user_name;
        $_SESSION['passworderror'] = 'invalid password';
        header("location:../");

    }
} else {
    $_SESSION['error'] = 'invalid request';
    echo "<h1 style='color:red;'>bad request</h1>";
    header("location:../");
}
