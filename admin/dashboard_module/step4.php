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

//for get if the user alredy uploaded movie
$query = "SELECT poster, banner, thumbnail ,certificate FROM movie WHERE id = :movieID";
$stmt = $pdo->prepare($query);
$stmt->execute([':movieID' => $movieID]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);




// todo
// session data
/**

    *UPDATE your_table
    *SET steps = JSON_SET(steps, '$.step6', true)
    *WHERE id = your_id; 
 

*/

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>CineVision | Upload Images</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    <style>
        .crop-container {
            width: auto;
            height: 100px;
            overflow: hidden;
        }

        .crop-container img {
            width: auto;
            height: 500px;
            object-fit: cover;
        }

        .posterImage {
            height: 200px;
            width: auto;
        }
    </style>

    <?php
    if (isset($_SESSION['serverError'])) {
        ?>
        <link rel="stylesheet" href="../../common/style/warning_alert.css">
        <?php
    }
    ?>

    <?php include("../common/css/style.html"); ?>
</head>

<body onload="loadBody()">
    <div class="container-fluid position-relative d-flex p-0">
        <?php include("../common/sidebar.php"); ?>
        <div class="content" id="content">

            <?php
            if (isset($_SESSION['serverError'])) {
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


            <?php include("../common/header.php"); ?>

            <?php
            include("../common/function.php");
            getMovieProgressStep($movieID, 4);

            ?>

            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <h4 class="mb-4 text-info">Upload Movie Images</h4>
                    <form id="uploadForm" action="../upload_movie_module/upload_process/proceed_step4.php" method="post"
                        enctype="multipart/form-data">
                        <input type="hidden" name="movieId" value="<?= $movieID ?>">

                        <!-- Poster Upload -->
                        <div class="row">
                            <div class="col-sm-12 col-xl-6">
                                <div class="mb-3">
                                    <label class="formFile mb-1" for="posterUpload">Upload Poster</label>
                                    <input class="form-control bg-dark" type="file" id="posterUpload">
                                    <button id="posterCropBtn" type="button"
                                        class="btn btn-primary d-none m-5">Upload</button>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xl-6">
                                <img id="posterImage" class="image-container crop-container">
                                <img id="posterCroppedImage" class="posterImage" style="height:250px"
                                    src="<?php echo $result['poster'] == null ? '"class="d-none"' : '../../uploads/movies/' . $movieID . '/photos/' . $result['poster'] ?>"
                                    </div>
                            </div>
                            <hr>

                            <!-- Banner Upload -->
                            <div class="row">
                                <div class="col-sm-12 col-xl-6">
                                    <div class="mb-3">
                                        <label class="formFile mb-1">Upload Banner</label>
                                        <input class="form-control bg-dark" type="file" id="bannerUpload">
                                        <button id="bannerCropBtn" type="button"
                                            class="btn btn-primary d-none m-5">Upload</button>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xl-6">
                                    <img id="bannerImage" class="image-container crop-container">
                                    <img id="bannerCroppedImage" style="height:250px"
                                        src="<?php echo $result['banner'] == null ? '"class="d-none"' : '../../uploads/movies/' . $movieID . '/photos/' . $result['banner'] ?>">
                                </div>
                            </div>
                            <hr>

                            <!-- Thumbnail Upload -->
                            <div class="row">
                                <div class="col-sm-12 col-xl-6">
                                    <div class="mb-3">
                                        <label class="formFile mb-1">Upload Thumbnail</label>
                                        <input class="form-control bg-dark" type="file" id="thumbnailUpload">
                                        <button id="thumbnailCropBtn" type="button"
                                            class="btn btn-primary d-none m-5">Upload</button>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xl-6">
                                    <img id="thumbnailImage" class="image-container crop-container">
                                    <img id="thumbnailCroppedImage" style="height:350px"
                                        src="<?php echo $result['thumbnail'] == null ? '"class="d-none"' : '../../uploads/movies/' . $movieID . '/photos/' . $result['thumbnail'] ?>">
                                </div>
                            </div>
                            <hr>

                            <!-- Certificate Upload -->
                            <div class="row">
                                <div class="col-sm-12 col-xl-6">
                                    <div class="mb-3">
                                        <label class="formFile mb-1">Upload Certificate</label>
                                        <input class="form-control bg-dark" type="file" id="certificateUpload">
                                        <button id="certificateCropBtn" type="button"
                                            class="btn btn-primary d-none m-5">Upload</button>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xl-6">
                                    <img id="certificateImage" class="image-container crop-container">
                                    <img id="certificateCroppedImage" style="height:250px"
                                        src="<?php echo $result['certificate'] == null ? '"class="d-none"' : '../../uploads/movies/' . $movieID . '/photos/' . $result['certificate'] ?>">
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-12 col-xl-6"></div>
                                <div class="col-sm-12 col-xl-6">
                                    <input type="submit" class="btn btn-primary" name="submit" value="Save & Next">
                                </div>
                            </div>
                    </form>
                </div>
            </div>

        </div>
        <?php include("../common/footer.php"); ?>
    </div>
    <?php
    // including css
    include("../common/js/script.html");
    ?>
    <script>
    function setupCropper(inputId, imageId, cropBtnId, croppedImageId, aspectX, aspectY, type) {
        let cropper;

        document.getElementById(inputId).addEventListener("change", function (event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                const image = document.getElementById(imageId);
                image.src = e.target.result;
                image.style.display = "block";
                document.getElementById(cropBtnId).classList.remove("d-none");
                document.getElementById(cropBtnId).classList.add("d-block");

                if (cropper) cropper.destroy();

                cropper = new Cropper(image, {
                    aspectRatio: aspectX / aspectY,
                    viewMode: 1,
                });
            };
            reader.readAsDataURL(file);
        });

        document.getElementById(cropBtnId).addEventListener("click", function () {
            if (cropper) {
                const croppedCanvas = cropper.getCroppedCanvas({
                    width: 1000,
                    height: (1000 * aspectY) / aspectX,
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high',
                });

                try {
                    croppedCanvas.toBlob(blob => {
                        const croppedImage = document.getElementById(croppedImageId);
                        croppedImage.src = URL.createObjectURL(blob);
                        croppedImage.style.display = "block";
                        croppedImage.classList.remove("d-none");

                        document.getElementById(imageId).style.display = "none";
                        document.getElementById(cropBtnId).classList.add("d-none");

                        // if (inputId === "posterUpload") {
                            croppedImage.style.height = "200px";
                        // }

                        const formData = new FormData();
                        formData.append("image", blob, type + ".jpg");
                        formData.append("movie_id", "<?= $movieID ?>");
                        formData.append("image_type", type);

                        fetch('../upload_movie_module/upload_process/proceed_step4.php', {
                            method: 'POST',
                            body: formData,
                        })
                            .then(response => response.text())
                            .then(data => {
                                if (
                                    data.includes("MOVIE ID NOT FOUND") ||
                                    data.includes("INVALID IMAGE TYPE") ||
                                    data.includes("INVALID FILE FORMAT") ||
                                    data.includes("IMAGE UPLOAD ERROR") ||
                                    data.includes("INVALID REQUEST")
                                ) {
                                    showErrorNotification(data, 5000);
                                }
                            })
                            .catch(error => {
                                alert(error);
                                console.error('Error:', error);
                            });

                        cropper.destroy();
                        cropper = null;
                    }, "image/jpeg", 0.95); // Quality set to 95%

                } catch (err) {
                    showErrorNotification("Failed to upload file!", 5000);
                }
            }
        });
    }

    // Setup cropper for different image types
    setupCropper("posterUpload", "posterImage", "posterCropBtn", "posterCroppedImage", 17, 24, "poster");
    setupCropper("bannerUpload", "bannerImage", "bannerCropBtn", "bannerCroppedImage", 16, 8, "banner");
    setupCropper("thumbnailUpload", "thumbnailImage", "thumbnailCropBtn", "thumbnailCroppedImage", 3, 2, "thumbnail");
    setupCropper("certificateUpload", "certificateImage", "certificateCropBtn", "certificateCroppedImage", 16, 8, "certificate");
</script>

</body>
<script>

    function loadBody() {
        const sidebar_title = document.getElementById('movies');
        sidebar_title.click();

        acivateSideBar(document.getElementById('pending_movie'));
        acivateSideBar(sidebar_title);

    }
</script>

</html>
<?php
if (isset($_SESSION['serverError'])) {
    ?>
    <script src="../../common/js/warning_alert.js"></script>
    <script>
        showErrorNotification("<?= $_SESSION['serverError'] ?>", 5000);
    </script>
    <?php
    unset($_SESSION['serverError']);
}
?>