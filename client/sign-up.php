<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinevision - Stream Your Movies</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            height: max-content;
            width: 90%;
            max-width: 500px;
            box-shadow: var(--shadow);
            border: 2px solid var(--primary-color);
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

        .gender-group {
            display: flex;
            gap: 20px;
        }

        .gender-option {
            position: relative;
            cursor: pointer;
            padding-left: 35px;
            font-size: 18px;
            user-select: none;
            transition: 0.3s;
        }

        .gender-option input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 22px;
            width: 22px;
            background-color: #333;
            border: 2px solid #999;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .gender-option:hover input~.checkmark {
            border-color: #fff;
        }

        .gender-option input:checked~.checkmark {
            background-color: #06c;
            border-color: #06c;
            box-shadow: 0 0 10px #06c;
        }

        .checkmark::after {
            content: "";
            position: absolute;
            display: none;
        }

        .gender-option input:checked~.checkmark::after {
            display: block;
        }

        .gender-option .checkmark::after {
            top: 5px;
            left: 5px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: white;
            transition: 0.3s;
        }
    </style>
</head>


<body>
    <!-- Sign Up Form -->
    <div class="form-container" id="signupForm">
        <div class="form-header">
            <h2><i class="fas fa-film"></i> Cinevision</h2>
            <p>Create your streaming account</p>
        </div>
        <form id="signup" method="post" action="proccess/register.php">
            <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" class="form-input" id="name" name="name" placeholder="Enter Name" required autofocus>
            </div>
            <div class="form-group">
                <i class="fas fa-envelope"></i>
                <input type="email" class="form-input" name="email" id="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <i class="fas fa-phone"></i>
                <input type="tel" class="form-input" id="contact" name="mobile" placeholder="Contact Number" required>
            </div>
            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" class="form-input" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <i class="fas fa-calendar"></i>
                <input type="date" class="form-input" id="dob" name="dob" required>
            </div>
            <div class="gender-group" style="margin-bottom:50px;color:white">
                <label class="gender-option">Male
                    <input type="radio" name="gender" value="0">
                    <span class="checkmark"></span>
                </label>

                <label class="gender-option">Female
                    <input type="radio" name="gender" value="1">
                    <span class="checkmark"></span>
                </label>

                <label class="gender-option">Other
                    <input type="radio" name="gender" value="2">
                    <span class="checkmark"></span>
                </label>
            </div>
            <button type="submit" class="btn" name="btnRegester" value="btnRegester">Sign Up</button>
        </form>
        <div class="form-footer">
            Already have an account? <a href="log-in.php">Sign In</a>
        </div>
    </div>


    <script>


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