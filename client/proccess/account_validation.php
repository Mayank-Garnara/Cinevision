<?php
session_start();
include("../common/connection/connection.php");

function validateProfileData($data) {
    $errors = [];
    
    // Validate name
    if (empty($data['name'])) {
        $errors['name'] = "Full name is required";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $data['name'])) {
        $errors['name'] = "Only letters and white space allowed";
    }
    
    // Validate email
    if (empty($data['email'])) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }
    
    // Validate phone
    if (!empty($data['phone']) && !preg_match("/^\+?[0-9]{10,15}$/", $data['phone'])) {
        $errors['phone'] = "Invalid phone number format";
    }
    
    return $errors;
}

function validatePasswordData($data) {
    $errors = [];
    
    // Validate current password
    if (empty($data['current_password'])) {
        $errors['current_password'] = "Current password is required";
    }
    
    // Validate new password
    if (empty($data['new_password'])) {
        $errors['new_password'] = "New password is required";
    } elseif (strlen($data['new_password']) < 8) {
        $errors['new_password'] = "Password must be at least 8 characters";
    }
    
    // Validate password confirmation
    if ($data['new_password'] !== $data['confirm_password']) {
        $errors['confirm_password'] = "Passwords do not match";
    }
    
    return $errors;
}

function updateProfile($userId, $data, $conn) {
    $stmt = $conn->prepare("UPDATE user SET name = ?, email = ?, phone = ? WHERE id = ?");
    $stmt->bind_param("sssi", $data['name'], $data['email'], $data['phone'], $userId);
    
    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Profile updated successfully'];
    } else {
        return ['success' => false, 'message' => 'Error updating profile: ' . $stmt->error];
    }
}

function updatePassword($userId, $currentPassword, $newPassword, $conn) {
    // First verify current password
    $stmt = $conn->prepare("SELECT password FROM user WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    if (!password_verify($currentPassword, $user['password'])) {
        return ['success' => false, 'message' => 'Current password is incorrect'];
    }
    
    // Update to new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE user SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $hashedPassword, $userId);
    
    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Password updated successfully'];
    } else {
        return ['success' => false, 'message' => 'Error updating password: ' . $stmt->error];
    }
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = [];
    
    if (isset($_POST['update_profile'])) {
        $errors = validateProfileData($_POST);
        
        if (empty($errors)) {
            $result = updateProfile($_SESSION['user_id'], $_POST, $conn);
            if ($result['success']) {
                $response = ['success' => true, 'message' => $result['message']];
            } else {
                $response = ['success' => false, 'errors' => ['general' => $result['message']]];
            }
        } else {
            $response = ['success' => false, 'errors' => $errors];
        }
    }
    
    if (isset($_POST['update_password'])) {
        $errors = validatePasswordData($_POST);
        
        if (empty($errors)) {
            $result = updatePassword(
                $_SESSION['user_id'],
                $_POST['current_password'],
                $_POST['new_password'],
                $conn
            );
            
            if ($result['success']) {
                $response = ['success' => true, 'message' => $result['message']];
            } else {
                $response = ['success' => false, 'errors' => ['general' => $result['message']]];
            }
        } else {
            $response = ['success' => false, 'errors' => $errors];
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>