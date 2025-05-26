<?php
session_start();
if (!isset($_SESSION['admin_data'])) {
    header("location:../login_module/index.php");
}
if (!isset(($_GET['movieId']))) {
    header("location: pending_movie.php");
}
$movieID = $_GET['movieId']; // get from url
include("../../common/connection/connection.php");
$selectMovieIdQuery = "SELECT id FROM movie WHERE id=?";
$selectMovieIdStmt = $pdo->prepare($selectMovieIdQuery);

$selectMovieIdStmt->execute([
    $movieID
]);
if ($selectMovieIdStmt->rowCount() == 1) {
    $_SESSION['movieId'] = $movieID;
} else {
    header("location:pending_movie.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Upload Movie</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <style>
        input[type="datetime-local"] {
            background-color: #1c1c1c;
            color: #fff;
            border: 2px solid #dc3545;
            border-radius: 10px;
            padding: 5px;
        }

        input[type="datetime-local"]:focus {
            outline: none;
            border-color: #ff4d4d;
            box-shadow: 0 0 5px #dc3545;
        }
    </style>
    <!-- Styles -->
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

        <?php
        // sidebar start
        include("../common/sidebar.php");
        //sidebar end
        ?>

        <!-- Content Start -->
        <div class="content" id="content">

            <!-- Navbar Start -->
            <?php include("../common/header.php"); ?>
            <!-- Navbar End -->

            <?php
            include("../common/function.php");
            getMovieProgressStep($_SESSION['movieId'], 6);

            ?>

            <div class="container-fluid pt-4 px-4" id="loading">
                <div class="bg-secondary rounded-top p-4">
                    <div class="col-sm-12 col-xl-9">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h4 class="mb-4 text-info">Movie upload</h4>

                            <div class="col-sm-12 col-xl-12">
                                <div class="bg-secondary rounded h-100 p-4">
                                    <form action="../upload_movie_module/upload_process/proceed_step6.php"
                                        method="post">
                                        <div class="col-sm-12 col-xl-12">
                                            <div class="bg-secondary rounded h-100 p-4">
                                                <div class="mb-3">
                                                    <label for="datetime" class="form-label">Select upload time</label>
                                                    <input class="" type="datetime-local" id="datetime"
                                                        name="dateToUpload">
                                                    <input type="submit" class="btn btn-danger"
                                                        value="Release according to this time">
                                                </div>
                                                <div class="text-danger p-3">
                                                    <?php
                                                        if(isset($_SESSION['error']['timeError'])){
                                                            echo $_SESSION['error']['timeError'];
                                                            unset($_SESSION['error']['timeError']);
                                                        }
                                                    ?>
                                                </div>
                                                ---OR---
                                            </div>
                                        </div>

                                    </form>
                                    <div class="mb-3">
                                        <label for="uploadNow" class="form-label">Release Now</label>
                                        <a href="../upload_movie_module/upload_process/proceed_step6.php?addNow=true">
                                            <input class="btn btn-danger" value="Release now" type="button"
                                                id="dateToUpload" name="uploadNow">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <!-- Content End -->
            <!-- Footer Start -->
            <?php
            include("../common/footer.php");
            ?>
            <!-- Footer End -->

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
        const sidebar_title = document.getElementById('movies');
        sidebar_title.click();

        acivateSideBar(document.getElementById('pending_movie'));
        acivateSideBar(sidebar_title);
    }
</script>
<script>
    const datetimeInput = document.getElementById('datetime');

    // Get current datetime and format to 'YYYY-MM-DDTHH:MM'
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset()); // Adjust timezone
    const formattedNow = now.toISOString().slice(0, 16);

    // Set minimum and default value
    datetimeInput.min = formattedNow;
    datetimeInput.value = formattedNow;

    // Optional: prevent manual entry of past datetime using validation
    datetimeInput.addEventListener('input', () => {
        if (datetimeInput.value < datetimeInput.min) {
            datetimeInput.value = datetimeInput.min;
        }
    });
</script>