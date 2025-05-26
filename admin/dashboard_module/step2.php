<?php
session_start();
if (!isset($_SESSION['admin_data'])) {
    header("location:../login_module/index.php");
}
if (!isset(($_GET['movieId']))) {
    header("location: pending_movie.php");
}
$movieID = $_GET['movieId']; // get from session or url
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
    <title>CineVision | Upload Movie</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link rel="stylesheet" href="../../common/style/shake.css">
    <link rel="stylesheet" href="../../common/style/sweet_alert.css">
    <script src="../../common/js/shake.js"></script>

    <?php
    // including css
    include("../common/css/style.html");
    ?>
    <!-- Styles -->
    <?php
    //for load warning alert css dynamically
    if (isset($_SESSION['serverError'])) {
        ?>
        <link rel="stylesheet" href="../../common/style/warning_alert.css">
        <?php
    }
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


        <?php
        // sidebar start
        include("../common/sidebar.php");
        //sidebar end
        ?>

        <!-- Content Start -->
        <div class="content" id="content">

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
            <!-- Navbar Start -->
            <?php include("../common/header.php"); ?>
            <!-- Navbar End -->


            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
            <!-- Select2 Bootstrap 5 Theme -->
            <link rel="stylesheet"
                href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

            <link rel="stylesheet" href="css/selectMultiple.css">
            <!-- Select2 CSS -->

            <?php
            include("../common/function.php");
            getMovieProgressStep($_SESSION['movieId'], 2);
            ?>

            <div class="container-fluid pt-4 px-4" id="loading">
                <div class="bg-secondary rounded-top p-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h4 class="mb-4 text-info">Movie Details</h4>
                            <?php
                            if (isset($_SESSION['form_data'])) {

                                $isFree = $_SESSION['form_data']['isFree'] ?? '';
                                $tags_predefinedValue = implode(",", $_SESSION['form_data']['tags']) ?? '';
                                $agrRating = $_SESSION['form_data']['age_rating'] ?? '';
                                $studioName = $_SESSION['form_data']['production_studio'] ?? '';
                                unset($_SESSION['form_data']);

                            } else {
                                $selectMovieDataQuery = "SELECT isFree,tags,age_rating,production_studio FROM movie WHERE id = ?";
                                $selectMovieDataStmt = $pdo->prepare($selectMovieDataQuery);

                                $selectMovieDataStmt->execute([
                                    $_SESSION['movieId']
                                ]);

                                $movieData = $selectMovieDataStmt->fetch(PDO::FETCH_ASSOC);

                                $isFree = $movieData['isFree'] ?? '';
                                $tags_predefinedValue = $movieData['tags'] ?? '';//tags which are coming from database table
                                $agrRating = $movieData['age_rating'] ?? '';
                                $studioName = $movieData['production_studio'] ?? '';
                            }

                            $validation_error_production_studio = '';
                            $validation_error_age_rating = '';
                            $validation_error_tags = '';
                            $validation_error_isFree = '';

                            if (isset($_SESSION['validation'])) {
                                $validation_error_production_studio = $_SESSION['validation']['validation_error_production_studio'] ?? '';
                                $validation_error_age_rating = $_SESSION['validation']['validation_error_age_rating'] ?? '';
                                $validation_error_tags = $_SESSION['validation']['validation_error_tags'] ?? '';
                                $validation_error_isFree = $_SESSION['validation']['validation_error_isFree'] ?? '';
                                unset($_SESSION['validation']);
                            }
                            ?>
                            <form id="myForm" action="../upload_movie_module/upload_process/proceed_step2.php"
                                method="post">
                                <div class="row mb-3">
                                    <label for="isFree" class="col-sm-4 col-form-label">Movie Available for</label>
                                    <div class="col-sm-8">
                                        <select name="isFree" id="isFree" class="form-select mb-3">
                                            <option value="" disabled selected>Select movie is paid or not</option>
                                            <option value="1" <?php
                                            if ($isFree == '1') {
                                                echo "selected";
                                            }
                                            ?>>All User
                                            </option>
                                            <option value="0" <?php if ($isFree == '0') {
                                                echo "selected";
                                            } ?>>Subscribed
                                                User
                                            </option>
                                        </select>
                                        <span id="isFreeError" class="error-message"
                                            style="color: red; display: none;">Please select movie is paid or
                                            not.</span>
                                        <?php
                                        if ($validation_error_isFree) {
                                            ?>
                                            <div class="text-primary error-message" id="errorMessage">
                                                <?= $validation_error_isFree ?>
                                            </div>
                                            <script>
                                                let element = document.getElementById('isFree');
                                                const errorMessage = document.getElementById('errorMessage');

                                                shake(element, errorMessage);
                                            </script>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="duration_minute" class="col-sm-4 col-form-label">Movie related
                                        tags</label>
                                    <div class="col-sm-8">

                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-12">
                                                <select class="form-control" id="multiple-select-field" name="tags[]"
                                                    data-placeholder="Choose anything" multiple>
                                                    <?php
                                                    $selectTags = "SELECT name FROM tag";
                                                    $stmt = $pdo->prepare($selectTags);

                                                    $stmt->execute();
                                                    $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($tags as $tag) {
                                                        ?>
                                                        <option value="<?= $tag['name'] ?>"><?= $tag['name'] ?></option>
                                                        <?php
                                                    }

                                                    if ($tags_predefinedValue) {
                                                        $tagsArr = explode(",", $tags_predefinedValue);
                                                        foreach ($tagsArr as $tagString) {
                                                            ?>
                                                            <option value="<?= $tagString ?>" selected><?= $tagString ?>
                                                            </option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <span id="selectedTagError" class="error-message"
                                                    style="color: red; display: none;">You have to select at least 1
                                                    tag</span>
                                                <?php
                                                if ($validation_error_tags) {
                                                    ?>
                                                    <div class="text-primary error-message" id="errorMessage">
                                                        <?= $validation_error_tags ?>
                                                    </div>
                                                    <script>
                                                        let element = document.getElementById('multiple-select-field');
                                                        const errorMessage = document.getElementById('errorMessage');

                                                        shake(element, errorMessage);
                                                    </script>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="age_rating" class="col-sm-4 col-form-label">Age Rating</label>
                                    <div class="col-sm-8">
                                        <!-- <input type="text" class="form-control" id="movie_year" name="movie_year"> -->
                                        <select name="age_rating" id="age_rating" class="form-select" name="age_rating">

                                            <option>Select age rating</option>
                                            <option value="G" <?php if ($agrRating == 'G') {
                                                echo "selected";
                                            } ?>>General
                                                (G)</option>
                                            <option value="PG" <?php if ($agrRating == 'PG') {
                                                echo "selected";
                                            } ?>>
                                                Parental Guidance (PG)</option>
                                            <option value="12+" <?php if ($agrRating == '12+') {
                                                echo "selected";
                                            } ?>>12+
                                            </option>
                                            <option value="16+" <?php if ($agrRating == '16+') {
                                                echo "selected";
                                            } ?>>16+
                                            </option>
                                            <option value="18+" <?php if ($agrRating == '18+') {
                                                echo "selected";
                                            } ?>>18+
                                            </option>
                                            <option value="R" <?php if ($agrRating == 'R') {
                                                echo "selected";
                                            } ?>>
                                                Restricted(R)</option>
                                        </select>
                                        <span id="age_ratingError" class="error-message"
                                            style="color: red; display: none;">Please select age rating.</span>
                                        <?php
                                        if ($validation_error_age_rating) {
                                            ?>
                                            <div class="text-primary error-message" id="errorMessage">
                                                <?= $validation_error_age_rating ?>
                                            </div>
                                            <script>
                                                let element = document.getElementById('age_rating');
                                                const errorMessage = document.getElementById('errorMessage');

                                                shake(element, errorMessage);
                                            </script>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="production_studio" class="col-sm-4 col-form-label">Studio Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="production_studio"
                                            id="production_studio" value="<?= $studioName ?>">
                                        <span id="studioError" class="error-message"
                                            style="color: red; display: none;">Please enter studio name.</span>
                                        <?php
                                        if ($validation_error_production_studio) {
                                            ?>
                                            <div class="text-primary error-message" id="errorMessage">
                                                <?= $validation_error_production_studio ?>
                                            </div>
                                            <script>
                                                let element = document.getElementById('production_studio');
                                                const errorMessage = document.getElementById('errorMessage');

                                                shake(element, errorMessage);
                                            </script>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div style="width:100%;display:flex;justify-content:end;">
                                    <button type="submit" class="btn btn-primary">Save & Next</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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

<script src="../../common/js/sweet_alert.js"></script>
<?php

if (isset($_SESSION["success"])) {
    ?>
    <script>
        showNotification("<?= $_SESSION['success'] ?>", 3000);
    </script>
    <?php
    unset($_SESSION['success']);
}
?>

<script>
    $(document).ready(function () {
        $('#multiple-select-field').select2({
            theme: "bootstrap-5",
            width: '100%',
            placeholder: "Choose anything",
            closeOnSelect: false,
            maximumSelectionLength: 5
        });


        $("#myForm").submit(function (event) {
            let valid = true;

            // Reset previous error messages
            $(".error-message").hide();

            // Check if the isFree is selected
            if ($("#isFree").val() === "") {
                let nameElement = document.getElementById('isFree');
                let nameError = document.getElementById('isFreeError');
                shake(nameElement, nameError);
                valid = false;
            }

            // Check at least one is selected
            if ($("#multiple-select-field option:selected").length === 0) {
                let multipleselectfield = document.getElementById('multiple-select-field');
                let selectedTagError = document.getElementById('selectedTagError');
                shake(multipleselectfield, selectedTagError);
                valid = false;
            }

            // Check if the rating is selected
            if ($("#age_rating").val() === "") {
                let age_rating = document.getElementById('age_rating');
                let age_ratingError = document.getElementById('age_ratingError');
                shake(age_rating, age_ratingError);
                valid = false;
            }

            // Check if the studio field is empty
            if ($("#production_studio").val() === "") {
                let production_studio = document.getElementById('production_studio');
                let studioError = document.getElementById('studioError');
                shake(production_studio, studioError);
                valid = false;
            }

            // Prevent form submission if validation fails
            if (!valid) {
                event.preventDefault();
            }
        }); 
    });
</script>

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