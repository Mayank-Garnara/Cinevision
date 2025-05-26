<?php
session_start();
include("../common/connection/connection.php");

// Check if user is logged in
if (!isset($_SESSION['user']['id'])) {
    header("Location: log-in.php");
    exit();
}

// Fetch current user data
try {
    $userId = $_SESSION['user']['id'];
    $stmt = $pdo->prepare("SELECT name, email, mobile FROM user WHERE id = :id");
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        throw new Exception("User not found");
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Error fetching user data: " . $e->getMessage();
    header("Location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Management - Play Show</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">
    <link href="css/account.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Overpass&display=swap" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    
    <style>
        /* Account Management Page Styles */
        .account-management-container {
            max-width: 1200px;
            margin: 150px auto 50px;
            padding: 2rem;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .account-title {
            font-size: 2rem;
            color: #333;
            margin-bottom: 2rem;
            text-align: center;
        }

        .account-sections {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .account-section {
            padding: 1.5rem;
            border-radius: 6px;
            background-color: #f9f9f9;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .account-section h2 {
            font-size: 1.5rem;
            color: #444;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #ddd;
        }

        .profile-picture-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 1rem;
            border: 3px solid #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .change-photo-btn {
            background-color: #e0e0e0;
            color: #333;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .change-photo-btn:hover {
            background-color: #d0d0d0;
        }

        .account-form {
            display: grid;
            gap: 1rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #555;
        }

        .form-group input,
        .form-group select {
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #4a90e2;
            box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
        }

        .text-danger {
            color: #e74c3c;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .save-btn {
            background-color: #4a90e2;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
            justify-self: start;
        }

        .save-btn:hover {
            background-color: #3a7bc8;
        }

        .danger-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .danger-btn {
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s;
            border: 1px solid #ddd;
            background-color: #f5f5f5;
        }

        .danger-btn:hover {
            background-color: #e0e0e0;
        }

        .delete-btn {
            background-color: #e74c3c;
            color: white;
            border-color: #e74c3c;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            max-width: 500px;
            width: 90%;
            position: relative;
        }

        .close-modal {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 1.5rem;
            cursor: pointer;
            color: #777;
        }

        .close-modal:hover {
            color: #333;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .modal-cancel-btn,
        .modal-confirm-btn {
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
        }

        .modal-cancel-btn {
            background-color: #f5f5f5;
            border: 1px solid #ddd;
        }

        .modal-confirm-btn {
            background-color: #4a90e2;
            color: white;
            border: none;
        }

        .modal-confirm-btn:hover {
            background-color: #3a7bc8;
        }

        /* Responsive Styles */
        @media (min-width: 768px) {
            .account-sections {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .account-sections {
                grid-template-columns: repeat(3, 1fr);
            }
        }
    </style>
</head>

<body>
    <div class="main clearfix position-relative">
        <?php include("common/pages/nav.php"); ?>
        <div class="main_about clearfix">
            <section id="center" class="center_blog">
                <div class="container-xl">
                    <div class="row center_o1">
                        <div class="col-md-12">
                            <h2 class="text-white">Account Settings</h2>
                            <h6 class="mb-0 mt-3 fw-normal col_red">
                                <a class="text-light" href="index.php">Home</a> 
                                <span class="mx-2 text-muted">/</span> Account
                            </h6>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="account-management-container">
        <h1 class="account-title">Account Management</h1>

        <div class="account-sections">
            <!-- Profile Section -->
            <section class="account-section profile-section">
                <h2>Profile Information</h2>
                <form id="profile-form" class="account-form">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['mobile']); ?>">
                    </div>
                    <button type="submit" class="save-btn">Save Changes</button>
                </form>
            </section>

            <!-- Password Section -->
            <section class="account-section password-section">
                <h2>Change Password</h2>
                <form id="password-form" class="account-form">
                    <div class="form-group">
                        <label for="current-password">Current Password</label>
                        <input type="password" id="current-password" name="current_password">
                    </div>
                    <div class="form-group">
                        <label for="new-password">New Password</label>
                        <input type="password" id="new-password" name="new_password">
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm New Password</label>
                        <input type="password" id="confirm-password" name="confirm_password">
                    </div>
                    <button type="submit" class="save-btn">Update Password</button>
                </form>
            </section>

            
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal" id="confirmation-modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h3 id="modal-title">Confirm Action</h3>
            <p id="modal-message">Are you sure you want to perform this action?</p>
            <div class="modal-actions">
                <button class="modal-cancel-btn">Cancel</button>
                <button class="modal-confirm-btn">Confirm</button>
            </div>
        </div>
    </div>


    <script>
        // Sticky navbar functionality
        window.onscroll = function() { myFunction() };

        var navbar_sticky = document.getElementById("navbar_sticky");
        var sticky = navbar_sticky.offsetTop;
        var navbar_height = document.querySelector('.navbar').offsetHeight;

        function myFunction() {
            if (window.pageYOffset >= sticky + navbar_height) {
                navbar_sticky.classList.add("sticky");
                document.body.style.paddingTop = navbar_height + 'px';
            } else {
                navbar_sticky.classList.remove("sticky");
                document.body.style.paddingTop = '0';
            }
        }

        // Form submission handling
        document.addEventListener('DOMContentLoaded', function() {
            // Profile form submission
            document.getElementById('profile-form').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                formData.append('update_profile', 'true');
                
                fetch('account_validation.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    // Clear previous errors
                    document.querySelectorAll('.text-danger').forEach(el => el.remove());
                    document.querySelectorAll('input').forEach(input => {
                        input.style.borderColor = '';
                    });

                    if (data.success) {
                        alert(data.message);
                    } else {
                        if (data.errors.general) {
                            alert(data.errors.general);
                        } else {
                            for (const [field, error] of Object.entries(data.errors)) {
                                const input = document.querySelector(`[name="${field}"]`);
                                if (input) {
                                    input.style.borderColor = '#e74c3c';
                                    const errorElement = document.createElement('div');
                                    errorElement.className = 'text-danger';
                                    errorElement.textContent = error;
                                    input.parentNode.appendChild(errorElement);
                                    
                                    // Remove error on input
                                    input.addEventListener('input', function() {
                                        this.style.borderColor = '';
                                        if (this.parentNode.querySelector('.text-danger')) {
                                            this.parentNode.removeChild(this.parentNode.querySelector('.text-danger'));
                                        }
                                    });
                                }
                            }
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating your profile.');
                });
            });

            // Password form submission
            document.getElementById('password-form').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                formData.append('update_password', 'true');
                
                fetch('account_validation.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    // Clear previous errors
                    document.querySelectorAll('.text-danger').forEach(el => el.remove());
                    document.querySelectorAll('#password-form input').forEach(input => {
                        input.style.borderColor = '';
                    });

                    if (data.success) {
                        alert(data.message);
                        this.reset();
                    } else {
                        if (data.errors.general) {
                            alert(data.errors.general);
                        } else {
                            for (const [field, error] of Object.entries(data.errors)) {
                                const input = document.querySelector(`[name="${field}"]`);
                                if (input) {
                                    input.style.borderColor = '#e74c3c';
                                    const errorElement = document.createElement('div');
                                    errorElement.className = 'text-danger';
                                    errorElement.textContent = error;
                                    input.parentNode.appendChild(errorElement);
                                    
                                    // Remove error on input
                                    input.addEventListener('input', function() {
                                        this.style.borderColor = '';
                                        if (this.parentNode.querySelector('.text-danger')) {
                                            this.parentNode.removeChild(this.parentNode.querySelector('.text-danger'));
                                        }
                                    });
                                }
                            }
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating your password.');
                });
            });

            // Modal handling
            const deactivateBtn = document.getElementById('deactivate-btn');
            const deleteBtn = document.getElementById('delete-btn');
            const modal = document.getElementById('confirmation-modal');
            const closeModal = document.querySelector('.close-modal');
            const modalCancel = document.querySelector('.modal-cancel-btn');
            const modalConfirm = document.querySelector('.modal-confirm-btn');

            let currentAction = null;

            deactivateBtn.addEventListener('click', function() {
                currentAction = 'deactivate';
                document.getElementById('modal-title').textContent = 'Deactivate Account';
                document.getElementById('modal-message').textContent = 'Are you sure you want to deactivate your account? You can reactivate it by logging in again.';
                modal.style.display = 'flex';
            });

            deleteBtn.addEventListener('click', function() {
                currentAction = 'delete';
                document.getElementById('modal-title').textContent = 'Delete Account';
                document.getElementById('modal-message').textContent = 'Are you sure you want to permanently delete your account? This action cannot be undone.';
                modal.style.display = 'flex';
            });

            closeModal.addEventListener('click', function() {
                modal.style.display = 'none';
            });

            modalCancel.addEventListener('click', function() {
                modal.style.display = 'none';
            });

            modalConfirm.addEventListener('click', function() {
                modal.style.display = 'none';
                // In a real implementation, you would make an AJAX call here
                if (currentAction === 'deactivate') {
                    alert('Account deactivated successfully. Sorry to see you go!');
                } else if (currentAction === 'delete') {
                    alert('Account deleted successfully. All your data has been removed.');
                }
            });

            // Close modal when clicking outside
            window.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>