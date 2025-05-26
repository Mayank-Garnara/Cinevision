<?php
session_start();
if (!isset($_SESSION['admin_data'])) {
    header("location:../login_module/index.php");
}
// if (!isset(($_GET['id']))) {
//     header("location: pending_movie.php");
// }
$movieID = 1; // get from session or url

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Upload Movie</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    
    <!-- Styles -->


    <?php
    // including css
    include("../common/css/style.html");
    ?>
    <!-- Styles -->

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

            <?php //this will included at run time ?>
            <div id="stepForm">
                <?php include("../upload_movie_module/step1.php") ?>
            </div>

            <!-- Footer Start -->
            <?php
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
        const sidebar_title = document.getElementById('movies');
        sidebar_title.click();

        acivateSideBar(document.getElementById('pending_movie'));
        acivateSideBar(sidebar_title);
    }
</script>
<script>
    function changeStep(stepId, movieId) {

        //for loading animation
        let data = ` <div id="spinner"
        class="show bg-dark position-fixed translate-middle w-50 vh-50 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
        </div>
        </div>`;

        $("#loading").html(data);



        $.ajax({
            url: "../upload_movie_module/" + stepId + ".php",
            method: "post",
            success: function (data) {
                $("#stepForm").html(data);
            },
            error: function (xhr, status, error) {
                if (xhr.status === 404) {
                    console.log("Error 404: Resource not found!");
                } else {
                    console.log("An error occurred:", status, error);
                }
            }
        });
    }
</script>

</html>