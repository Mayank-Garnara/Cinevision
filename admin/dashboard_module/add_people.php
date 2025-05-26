<?php
session_start();
if (!isset($_SESSION['admin_data'])) {
    header("location:../login_module/index.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>CineVision | Add People</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <?php
    if (isset($_SESSION['success'])) {
        ?>
        <link rel="stylesheet" href="../../common/style/sweet_alert.css">

        <?php
    }

    if (isset($_SESSION['photo_error'])) {
        ?>
        <link rel="stylesheet" href="../../common/style/warning_alert.css">
        <?php
    }
    ?>

    <?php
    // including css
    include("../common/css/style.html");
    ?>
</head>

<body onload="loadBody()">
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <?php
        // including sidebar
        include("../common/sidebar.php");
        ?>

        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content" id="content">
            <!-- Navbar Start -->
            <?php
            if (isset($_SESSION['success'])) {
                ?>
                <!-- sweet notification -->
                <div id="custom-notification" class="notification hidden">
                    <div class="icon" style="background-color: #28a745;">
                        <svg id="checkmark-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52" class="checkmark">
                            <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none" />
                            <path class="checkmark-check" fill="none" d="M14 27l10 10 14-20" />
                        </svg>
                    </div>
                    <p id="notification-message">Operation successful!</p>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($_SESSION['photo_error'])) {
                ?>
                <div id="error-notification" class="notification hidden">
                    <div id="icon">
                        <svg id="cross-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52" class="cross">
                            <circle class="cross-circle" cx="26" cy="26" r="25" fill="none" />
                            <path class="cross-line" fill="none" d="M16 16l20 20M36 16l-20 20" />
                        </svg>
                    </div>
                    <p id="error-message">An error occurred!</p>
                </div>
                <?php
            }
            ?>

            <?php
            // including header
            include("../common/header.php");
            ?>
            <!-- Navbar End -->

            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded h-100 p-4">
                            <form action="process/add_people_process.php" method="post" enctype="multipart/form-data">
                                <h6 class="mb-4">Add People</h6>
                                <div class="form-floating mb-3">
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Name">
                                    <label for="name">Name</label>
                                </div>
                                <div class=" mb-3">
                                    <input type="file" name="image" accept=".jpg , .jpeg" class="form-control bg-dark"
                                        id="personImage">
                                </div>
                                <input type="reset" value="clear form" class="btn btn-success">
                                <button type="submit" class="btn btn-primary" id="submit"
                                    value="Add person">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Footer Start -->
            <?php
            // including css
            include("../common/footer.php");
            ?>
            <!-- Footer End -->
        </div>
        <!-- Content End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <?php
    // including css
    include("../common/js/script.html");
    ?>
</body>
<script>
    function loadBody() {
        const sidebar_title = document.getElementById('add_people');

        acivateSideBar(sidebar_title);
    }
</script>
<?php
if (isset($_SESSION["success"])) {
    // for load sweet notification script dynamically
    ?>
    <script src="../../common/js/sweet_alert.js"></script>

    <script>
        showNotification("<?= $_SESSION['success'] ?>", 3000);
    </script>
    <?php
    unset($_SESSION['success']);
}
?>

<?php
if (isset($_SESSION['photo_error'])) {
    ?>
    <script src="../../common/js/warning_alert.js"></script>
    <script>
        showErrorNotification("<?= $_SESSION['photo_error'] ?>", 5000);
    </script>
    <?php
    unset($_SESSION['photo_error']);
}
?>

</html>