<?php
session_start();
if (!isset($_SESSION['set_pass'])) {
    header("location:index.php");
}

if (isset($_SESSION['admin_data'])) {
    header("location:../dashboard_module/index.php");
}
if (isset($_SESSION["error"])) {
    ?>
    <script>alert("<?= $_SESSION['error'] ?>")</script>
    <?php
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineVision-new password</title>
    <style>
        <?php include('../../common/style/loginstyle.php'); ?>
    </style>
    <link rel="stylesheet" href="../../common/style/gradient_logo.css">
    <script src="../../common/js/shake.js"></script>
</head>

<body>

    <div class="cinevision_container">
        <div class="cinevision-logo">CineVision</div>
        <form id="container" action="login_process/update_password.php" method="post" onsubmit="return checkpassword()">

            <h3 id="Heading">New password</h3>

            <label>Password:</label>
            <div class="row">

                <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="30px">
                        <path
                            d="M336 352c97.2 0 176-78.8 176-176S433.2 0 336 0S160 78.8 160 176c0 18.7 2.9 36.8 8.3 53.7L7 391c-4.5 4.5-7 10.6-7 17v80c0 13.3 10.7 24 24 24h80c13.3 0 24-10.7 24-24V448h40c13.3 0 24-10.7 24-24V384h40c6.4 0 12.5-2.5 17-7l33.3-33.3c16.9 5.4 35 8.3 53.7 8.3zM376 96a40 40 0 1 1 0 80 40 40 0 1 1 0-80z" />
                    </svg></div><input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <label>Confirm Password:</label>
            <div class="row">

                <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="30px">
                        <path
                            d="M336 352c97.2 0 176-78.8 176-176S433.2 0 336 0S160 78.8 160 176c0 18.7 2.9 36.8 8.3 53.7L7 391c-4.5 4.5-7 10.6-7 17v80c0 13.3 10.7 24 24 24h80c13.3 0 24-10.7 24-24V448h40c13.3 0 24-10.7 24-24V384h40c6.4 0 12.5-2.5 17-7l33.3-33.3c16.9 5.4 35 8.3 53.7 8.3zM376 96a40 40 0 1 1 0 80 40 40 0 1 1 0-80z" />
                    </svg></div><input type="password" name="confirm_password" id="confirm_password"
                    placeholder="Confirm password" required>
            </div>
            <div id="passwordTooltip" class="error-message"></div>
            <div id="confirmPasswordTooltip" class="error-message"></div>
            <div id="errorMessage" class="error-message">Please fix the password issues before submitting the form.
            </div>

            <button type="submit">Update</button>
            </span>
        </form>
    </div>

</body>
<script src="../../common/js/password_manage.js"></script>

</html>