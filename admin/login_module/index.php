<?php
session_start();
//if this will set then user is not able to see this page without logged out
if (isset($_SESSION['admin_data'])) {
    header("location:../dashboard_module/index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinevision | Login</title>
    <style>
        <?php include('../../common/style/loginstyle.php'); ?>
    </style>
    <link rel="stylesheet" href="../../common/style/sweet_alert.css">
    <link rel="stylesheet" href="../../common/style/gradient_logo.css">
</head>

<body>

    <div id="custom-notification" class="notification hidden">
        <div class="icon" style="background-color: #28a745;">
            <svg id="checkmark-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52" class="checkmark">
                <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none" />
                <path class="checkmark-check" fill="none" d="M14 27l10 10 14-20" />
            </svg>
        </div>
        <p id="notification-message">Operation successful!</p>
    </div>

    <div class="cinevision_container">
        <div class="cinevision-logo">CineVision</div>
        
        <form id="container" action="login_process/login_process.php" method="post">

            <h3 id="Heading">Sign In</h3>
            <label>Email or Mobile no. :</label>
            <div class="row">
                <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="100%">
                        <path
                            d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                    </svg></div><input type="text" name="email" placeholder="Email or Mobile no." value="<?php
                    if (isset($_SESSION['stateManage_userId'])) {
                        echo $_SESSION['stateManage_userId'];
                        unset($_SESSION['stateManage_userId']);
                    }
                    ?>" required>
            </div>
            <label>Password:</label>

            <div class="row">

                <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="30px">
                        <path
                            d="M336 352c97.2 0 176-78.8 176-176S433.2 0 336 0S160 78.8 160 176c0 18.7 2.9 36.8 8.3 53.7L7 391c-4.5 4.5-7 10.6-7 17v80c0 13.3 10.7 24 24 24h80c13.3 0 24-10.7 24-24V448h40c13.3 0 24-10.7 24-24V384h40c6.4 0 12.5-2.5 17-7l33.3-33.3c16.9 5.4 35 8.3 53.7 8.3zM376 96a40 40 0 1 1 0 80 40 40 0 1 1 0-80z" />
                    </svg></div><input id="password" type="password" name="password" placeholder="Password" required>
            </div>
            <div id="errorMessage" class="error-message">
                <?php
                if (isset($_SESSION['passworderror'])) {
                    //this will be unset after giving shaking effect
                    echo $_SESSION['passworderror'];
                }
                ?>
            </div>

            <button type="submit">Sign In</button>
            <span><span><a href="forgot_password.php">Forgot Password?</a></span>
            </span>
        </form>
    </div>


</body>

<?php

//if this will set then it wll say that password or id not match
if (isset($_SESSION['passworderror'])) {
    ?>
    <script src="../../common/js/shake.js"></script>
    <script>

        let passwordInput = document.getElementById('password');
        const errorMessage = document.getElementById('errorMessage');

        shake(passwordInput, errorMessage);

    </script>
    <?php
    unset($_SESSION['passworderror']);
}

?>
<script src="../../common/js/sweet_alert.js"></script>
<?php

if (isset($_SESSION["error"])) {
    ?>
    <script>
        showNotification('<?= $_SESSION['error'] ?>', 3000);
    </script>
    <?php
    unset($_SESSION['error']);
}
?>


</html>