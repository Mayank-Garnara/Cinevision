<?php
session_start();
if(isset($_POST['txtOTP']) && !empty(trim($_POST['txtOTP'])) && isset($_SESSION['otp']) && $_SESSION['otp_email'] && isset($_POST['token']) && $_POST['token']=="verifyOTP")
{
    if($_POST["txtOTP"] == $_SESSION['otp'])
    {
        $_SESSION['set_pass']=true;
        unset($_SESSION['otp']);
        echo 'valid_otp';
    }
    else
    {
        $_SESSION['error'] = "Invalid OTP !";
        echo 'invalid_otp';
    }
}
else 
    echo "invalid request";
?>