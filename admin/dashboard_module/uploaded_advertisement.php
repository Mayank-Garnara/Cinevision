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
    <title></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">


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
            // including header
            include("../common/header.php");
            ?>
            <!-- Navbar End -->

            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    Uploadeded Advertisement data will be here
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
    function loadBody(){
        const sidebar_title =document.getElementById('advertisement');
        sidebar_title.click();
        
        acivateSideBar(document.getElementById('uploaded_advertisement'));
        acivateSideBar(sidebar_title);
    }
</script>
</html>