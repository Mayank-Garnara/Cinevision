<?php
session_start();
if (isset($_SESSION['admin_data'])) {
    header("location:../dashboard_module/index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinevision-forgot password</title>
    <style>
        <?php include('../../common/style/loginstyle.php'); ?>
        #afterotp {
            display: none;
        }
    </style>
    <link rel="stylesheet" href="../../common/style/warning_alert.css">
    <link rel="stylesheet" href="../../common/style/gradient_logo.css">

    <script src="../../common/js/jquery.min.js"></script>
    <script src="../../common/js/shake.js"></script>
</head>

<body>
    <div id="error-notification" class="notification hidden">
        <div id="icon">
            <svg id="cross-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52" class="cross">
                <circle class="cross-circle" cx="26" cy="26" r="25" fill="none" />
                <path class="cross-line" fill="none" d="M16 16l20 20M36 16l-20 20" />
            </svg>
        </div>
        <p id="error-message">An error occurred!</p>
    </div>

    <div class="cinevision_container">
        <div class="cinevision-logo">CineVision</div>

        <form method="post" id="container">

            <h3 id="Heading">Otp validation</h3>
            <label>User id:</label>
            <div class="row">
                <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="100%">
                        <path
                            d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                    </svg></div><input type="text" name="email" id="email" placeholder="User id OR mobile number"
                    required>
            </div>
            <div id="errorMessage" class="error-message">Please enter valid account name</div>
            <div style="align-self: flex-end;" onclick="sendOtp()"><button type="button" id="otpButton">Get OTP</button>
            </div>
            <!-- from this line this code will visible after click on Get OTP button -->
            <div id="afterotp">
                <label>Enter otp which is sent to <b id="user_name_at_otp_time">abc@gmail.com<b> : </label>
                <div class="row">

                    <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="30px">
                            <path
                                d="M336 352c97.2 0 176-78.8 176-176S433.2 0 336 0S160 78.8 160 176c0 18.7 2.9 36.8 8.3 53.7L7 391c-4.5 4.5-7 10.6-7 17v80c0 13.3 10.7 24 24 24h80c13.3 0 24-10.7 24-24V448h40c13.3 0 24-10.7 24-24V384h40c6.4 0 12.5-2.5 17-7l33.3-33.3c16.9 5.4 35 8.3 53.7 8.3zM376 96a40 40 0 1 1 0 80 40 40 0 1 1 0-80z" />
                        </svg></div><input type="text" name="otp" id="txtOTP" placeholder="Enter OTP " required>
                </div>

                <button type="button" id="btnVerify" onclick="verifyOTP()">Verify</button>
                <a href="set_new_password.php" style="display:none" id="go_to_chnage_password"></a>
            </div>

        </form>
    </div>

</body>
<script src="../../common/js/sendotp.js"></script>
<script src="../../common/js/verifyotp.js"></script>
<script src="../../common/js/warning_alert.js"></script>



</html>