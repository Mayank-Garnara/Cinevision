<?php
session_start();

if (isset($_POST['email']) && isset($_POST['token']) && $_POST['token'] == "send_otp" && strlen(trim($_POST['email'])) > 0) {

    $email = $_POST["email"];
    include '../../../common/connection/connection.php';

    $sql = "SELECT * FROM admin WHERE email = :email or phone =:phone limit 1 ";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        'email' => $email,
        'phone' => $email
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $recevierMail = $user['email'];
        $name = $user['name'];
        $subject = 'Confirmation OTP';

        $otp=0;

        if(isset($_SESSION['otp']) && isset($_SESSION['otp_email']) && $_SESSION['otp_email'] == $recevierMail ) {
            $GLOBALS['otp'] = $_SESSION['otp'];
        }else
        {
            $GLOBALS['otp'] = rand(100000,999999);
            $_SESSION['otp']= $otp;
            $_SESSION['otp_email'] = $recevierMail;
        }

        $body = '<!DOCTYPE html>
                    <html>
                    <head>
                    <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        margin: 0;
                        padding: 0;
                    }
                    .email-container {
                        max-width: 600px;
                        margin: 20px auto;
                        background-color: #ffffff;
                        border: 1px solid #ddd;
                        border-radius: 5px;
                        overflow: hidden;
                        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                    }
                    .email-header {
                        background-color: #4caf50;
                        color: #ffffff;
                        text-align: center;
                        padding: 15px;
                        font-size: 20px;
                    }
                    .email-body {
                        padding: 20px;
                        text-align: center;
                        color: #333333;
                    }
                    .otp-code {
                        display: inline-block;
                        font-size: 28px;
                        font-weight: bold;
                        color: #4caf50;
                        background-color: #f4f4f4;
                        border: 1px dashed #4caf50;
                        padding: 10px 20px;
                        margin: 20px 0;
                    }
                    .email-footer {
                        background-color: #f9f9f9;
                        text-align: center;
                        padding: 10px;
                        font-size: 12px;
                        color: #888888;
                    }
                    </style>
                    </head>
                    <body>
                    <div class="email-container">
                    <div class="email-header">
                        Your OTP Code
                    </div>
                    <div class="email-body">
                        <p>Hello,</p>
                        <p>Use the following OTP to complete your process. This OTP is valid for the next 10 minutes:</p>
                        <div class="otp-code">'.$otp.'</div>
                        <p>If you didn’t request this, please ignore this email.</p>
                    </div>
                    <div class="email-footer">
                        © 2025 CineVision. All rights reserved.
                    </div>
                    </div>
                    </body>
                    </html>';

        include("send_mail.php");
        $val = sendMail($recevierMail, $name, $subject, $body);
        if($val)
        {
            include("../../../common/functions/maskEmail.php");
            echo maskEmail($recevierMail);
        }
        else
            echo "not_sent" ;
    }
    else
    {
        echo "user_not_found";
    }
}

?>