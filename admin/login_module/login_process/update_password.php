<?php
session_start();
if(isset($_POST["password"]) && isset($_SESSION['otp_email']) && isset($_POST['confirm_password'])) {
    if($_POST['password']==$_POST['confirm_password'])
    {
        include '../../../common/connection/connection.php';
        $email = $_SESSION['otp_email'];
        $hasedPassword = md5($_POST['password']);

        $query = 'UPDATE admin set password= :password where email= :email';
        $stmt = $pdo->prepare($query);
        $result= $stmt->execute(
            [
                'password'=> $hasedPassword,
                'email' => $email
            ]
        );

        if ($result) {
            unset($_SESSION['set_pass']);
            $_SESSION['error'] = 'password updated';
            header("location:../index.php");
        } else {
           
            $_SESSION["error"] = "Failed to update password";
            header("location:../index.php");
        }

    }else
    {
        $_SESSION['error']= 'password not matched. !';
        header('location:../set_new_password.php');  
    }

}else
{
    echo "invalid request";
    header('location:../index.php');
}
?>