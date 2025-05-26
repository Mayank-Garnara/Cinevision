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

    <!-- Styles -->
    <?php
    // including css
    include("../common/css/style.html");
    ?>
    <!-- Styles -->
    <style>
        progress {
            display: none;
            width: 300px;
            height: 20px;
            background-color: #f0f0f0;
            /* Background color */
            border-radius: 5px;
            overflow: hidden;
        }

        /* Change the color of the progress value */
        progress::-webkit-progress-bar {
            background-color: #f0f0f0;
            /* Background of the bar */
        }

        progress::-webkit-progress-value {
            background-color: rgb(255, 0, 0);
            /* Color of the progress value */
        }

        progress::-moz-progress-bar {
            background-color: #4caf50;
            /* Color for Firefox */
        }
    </style>

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
            getMovieProgressStep($_SESSION['movieId'], 5);

            ?>

            <div class="container-fluid pt-4 px-4" id="loading">
                <div class="bg-secondary rounded-top p-4">
                    <div class="col-sm-12 col-xl-9">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h4 class="mb-4 text-info">Movie Upload</h4>
                            <div
                                style="background: #fff3cd; color: #856404; padding: 10px; border: 1px solid #ffeeba; border-radius: 5px; text-align: center; font-weight: bold;">
                                Please <span style="color: red;">do not leave this page</span> while the video is
                                uploading.
                                Wait until the status shows <b>"Finishing"</b> or <b>"Touching Up"</b> before navigating
                                away.
                                Leaving the page earlier before it show "finishing up" may cause the upload to fail.
                            </div>

                            <form action="" onsubmit="" id="uploadForm">
                                <div class="col-sm-12 col-xl-12">
                                    <div class="bg-secondary rounded h-100 p-4">

                                        <?php
                                        $isVideoInDbQuery = "SELECT movie,trailer,teaser FROM movie WHERE id=:id";
                                        $isVideoInDbStmt = $pdo->prepare($isVideoInDbQuery);
                                        $isVideoInDbStmt->bindParam(":id", $_SESSION['movieId']);
                                        $isVideoInDbStmt->execute();
                                        $isVideoInDbResult = $isVideoInDbStmt->fetch(PDO::FETCH_ASSOC);

                                        if ($isVideoInDbResult['teaser'] != null) {
                                            echo "<span style='color:red'>Teaser is already uploaded ! if you will add teaser again then old one will replace with new teaser</span>";
                                        }
                                        ?>
                                        <!-- Teaser -->
                                        <div class="mb-3">
                                            <label for="formFile" class="form-label">Upload Teaser</label>
                                            <input class="form-control bg-dark" type="file" id="teaser" name="teaser">
                                        </div>
                                        <div>
                                            <div class="pg-bar mb-3">
                                                <progress id="teaserProgressBar" min="0" max="100"
                                                    style="width:100%; color:red;"></progress>
                                            </div>
                                            <div>
                                                <span id="teaserProgressText">Select teaser to upload</span>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end" id="teaser_pending_label">
                                            <?php
                                            if ($isVideoInDbResult['teaser'] != null) {
                                                ?>
                                                <span style="color:green">Done</span>
                                                <?php
                                            } else {
                                                ?>
                                                pending
                                                <?php
                                            }
                                            ?>
                                        </div>

                                        <?php
                                        if ($isVideoInDbResult['trailer'] != null) {
                                            echo "<span style='color:red'>Trailer is already uploaded ! if you will add trailer again then old one will replace with new trailer</span>";
                                        }
                                        ?>
                                        <!-- Trailler -->
                                        <div class="mb-3">
                                            <label for="formFile" class="form-label">Upload Trailer</label>
                                            <input class="form-control bg-dark" type="file" id="trailer">
                                        </div>
                                        <div>
                                            <div class="pg-bar mb-3">
                                                <progress id="trailerProgressBar" min="0" max="100"
                                                    style="width:100%; color:red;"></progress>
                                            </div>
                                            <div>
                                                <span id="trailerProgressText">Select trailer to upload</span>
                                            </div>
                                        </div>
                                        <div class="d-flex  justify-content-end" id="trailer_pending_label">
                                            <?php
                                            if ($isVideoInDbResult['trailer'] != null) {
                                                ?>
                                                <span style="color:green">Done</span>
                                                <?php
                                            } else {
                                                ?>
                                                pending
                                                <?php
                                            }
                                            ?>
                                        </div>


                                        <?php
                                        if ($isVideoInDbResult['movie'] != null) {
                                            echo "<span style='color:red'>Movie is already uploaded ! if you will add movie again then old one will replace with new movie</span>";
                                        }
                                        ?>
                                        <div class="">
                                            <label for="formFile" class="form-label">Upload Movie</label>
                                            <input class="form-control bg-dark" type="file" id="movie">
                                        </div>
                                        <div>
                                            <div class="pg-bar mb-3 mt-3">
                                                <progress id="movieProgressBar" min="0" max="100"
                                                    style="width:100%; color:red;"></progress>
                                            </div>
                                            <div>
                                                <span id="movieProgressText">Select movie to upload</span>
                                            </div>
                                            </di v>
                                            <div class="d-flex  justify-content-end" id="movie_pending_label">
                                                <?php
                                                if ($isVideoInDbResult['movie'] != null) {
                                                    ?>
                                                    <span style="color:green">Done</span>
                                                    <?php
                                                } else {
                                                    ?>
                                                    pending
                                                    <?php
                                                }
                                                ?>
                                            </div>

                                            <div class="mt-3 d-flex justify-content-end ">
                                                <input type="submit" class="btn btn-primary" value="Save & Next">
                                            </div>

                                        </div>
                                    </div>
                            </form>

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

    let isUploading = false;
    // Call this function when upload starts
    function startUpload() {
        isUploading = true;
    }

    // Call this function when upload finishes
    function finishUpload() {
        isUploading = false;
    }
    window.addEventListener("beforeunload", function (event) {
        if (isUploading) {
            event.preventDefault();
            event.returnValue = "Your upload is in progress. Are you sure you want to leave?";
        }
    });

    function uploadFile(movieFileId, videoType, progressBar, progressText) {
        document.getElementById(progressBar).style.display = "block";
        let formData = new FormData();
        let videoFile = document.getElementById(movieFileId).files[0];

        formData.append('movieFile', videoFile);
        formData.append("videoType", videoType);

        let xhr = new XMLHttpRequest();

        startUpload();

        xhr.upload.onprogress = function (event) {
            if (event.lengthComputable) {
                let percentComplete = Math.round((event.loaded / event.total) * 100);
                document.getElementById(progressBar).value = percentComplete;
                document.getElementById(progressText).innerText = percentComplete + "% uploaded";
                document.getElementById(videoType + "_pending_label").style.color = "green";
                document.getElementById(videoType + "_pending_label").innerText = "In progress...";

                if (percentComplete == 100) {
                    document.getElementById(progressText).innerText = "Video uploaded ! final touching is on...";
                    finishUpload();
                }

            }
        };

        xhr.onload = function () {
            if (xhr.status === 200) {
                
                //for testing perpose
                // alert(xhr.responseText);
                // console.log(xhr.responseText);
                
                
                document.getElementById(videoType + "_pending_label").style.color = "green";
                document.getElementById(videoType + "_pending_label").innerText = "Done";

                document.getElementById(progressText).innerText = "Upload complete!";
            } else {
                document.getElementById(progressText).innerText = "Upload failed.";
            }
        };

        xhr.open("POST", "../upload_movie_module/upload_process/proceed_step5.php", true);
        xhr.send(formData);
    }

    document.getElementById("teaser").addEventListener("change", function (event) {
        uploadFile("teaser", "teaser", "teaserProgressBar", "teaserProgressText");
    });

    document.getElementById("trailer").addEventListener("change", function (event) {
        uploadFile("trailer", "trailer", "trailerProgressBar", "trailerProgressText");
    });

    document.getElementById("movie").addEventListener("change", function (event) {
        uploadFile("movie", "movie", "movieProgressBar", "movieProgressText");
    });



</script>