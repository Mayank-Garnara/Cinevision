<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinevision - Stream Your Movies</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <style>
        :root {
            --primary-color: #dc3545;
            --dark-color: #1a1a1a;
            --light-color: #ffffff;
            --shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
            background-color: #343a40;
            background:
                linear-gradient(to bottom, rgba(0, 0, 0, 0.8), rgba(255, 255, 255, 0.1)),
                url('../common/images/background.png') no-repeat center center/cover;
            /* background-image: url('../common/images/background.png'); */
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            background: rgba(18, 1, 1, 0.553);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 15px;
            width: 90%;
            height: max-content;
            max-width: 500px;
            box-shadow: var(--shadow);
            border: 2px solid #ffd7d738;
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-header h2 {
            color: var(--light-color);
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: #888;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        .form-input {
            width: 100%;
            padding: 12px 12px 12px 40px;
            border: 2px solid #333;
            border-radius: 8px;
            background: #2b2b2b;
            color: var(--light-color);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 8px rgba(220, 53, 69, 0.3);
        }

        .radio-group {
            display: flex;
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .radio-label {
            display: flex;
            align-items: center;
            color: #888;
            cursor: pointer;
        }

        .radio-label input {
            margin-right: 0.5rem;
            accent-color: var(--primary-color);
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: var(--primary-color);
            border: none;
            border-radius: 8px;
            color: var(--light-color);
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn:hover {
            background: #c82333;
            transform: translateY(-2px);
        }

        .form-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: #888;
        }

        .form-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: bold;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>



    <!-- Sign In Form -->
    <div class="form-container " id="signinForm">


        <div class="form-header">
            <h2><i class="fas fa-film"></i> Cinevision</h2>
            <p>Welcome! Please sign in</p>
        </div>
        <form id="signin" method="post" action="proccess/log-in.php">

            <?php
            if (isset($_SESSION['logInError'])) {
                ?>
                <div class="alert alert-danger">
                    <?= $_SESSION["logInError"] ?>
                </div>
                <?php
                unset($_SESSION['logInError']);
            }
            ?>

            <div class="form-group">
                <i class="fas fa-envelope"></i>
                <input type="email" class="form-input" placeholder="Email" required name="email" autofocus>
            </div>
            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" class="form-input" placeholder="Password" name="password" required>
            </div>
            <button type="submit" class="btn" name="btnLogIn" value="btnLogIn">Sign In</button>
        </form>
        <div class="form-footer">
            Don't have an account? <a href="sign-up.php">Create Account</a>
        </div>
    </div>

    <script>
        function toggleForms() {
            document.getElementById('signupForm').classList.toggle('hidden');
            document.getElementById('signinForm').classList.toggle('hidden');
        }

        // Client-side validation (optional)
        document.getElementById('signup').addEventListener('submit', function (e) {
            const password = document.getElementById('password').value;
            const email = document.getElementById('email').value;

            if (password.length < 8) {
                alert('Password must be at least 8 characters!');
                e.preventDefault();
            }

            if (!validateEmail(email)) {
                alert('Please enter a valid email address!');
                e.preventDefault();
            }
        });

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
    </script>
</body>

</html>