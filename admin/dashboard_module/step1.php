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

    <!-- Styles -->
    <?php
    if (isset($_SESSION['validation'])) {
        ?>
        <link rel="stylesheet" href="../../common/style/shake.css">
        <script src="../../common/js/shake.js"></script>
        <?php
    }
    ?>
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

            <!-- Navbar Start -->
            <?php include("../common/header.php"); ?>
            <!-- Navbar End -->

            <!-- Progress list -->

            <?php
            include("../common/function.php");
            getMovieProgressStep($_SESSION['movieId'], 1);
            ?>


            <!-- Progress list end -->

            <div class="container-fluid pt-4 px-4" id="loading">
                <div class="bg-secondary rounded-top p-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h4 class="mb-4 text-info">Basic Details</h4>
                            <?php
                            if (isset($_SESSION['form_data'])) {

                                $name = $_SESSION['form_data']['name'] ?? '';
                                $duration_minute = $_SESSION['form_data']['duration_minute'] ?? '';
                                $movie_year = $_SESSION['form_data']['movie_year'] ?? '';
                                $description = $_SESSION['form_data']['description'] ?? '';

                                unset($_SESSION['form_data']);

                            } else {
                                $selectMovieDataQuery = "SELECT name,duration_minute,movie_year,description FROM movie WHERE id = ?";
                                $selectMovieDataStmt = $pdo->prepare($selectMovieDataQuery);

                                $selectMovieDataStmt->execute([
                                    $_SESSION['movieId']
                                ]);

                                $movieData = $selectMovieDataStmt->fetch(PDO::FETCH_ASSOC);

                                $name = $movieData['name'] ?? '';
                                $duration_minute = $movieData['duration_minute'] ?? '';//tags which are coming from database table
                                $movie_year = $movieData['movie_year'] ?? '';
                                $description = $movieData['description'] ?? '';
                            }

                            $validation_error_name = '';
                            $validation_error_duration_minute = '';
                            $validation_error_movie_year = '';
                            $validation_error_description = '';

                            if (isset($_SESSION['validation'])) {
                                $validation_error_name = $_SESSION['validation']['validation_error_name'] ?? '';
                                $validation_error_duration_minute = $_SESSION['validation']['validation_error_duration_minute'] ?? '';
                                $validation_error_movie_year = $_SESSION['validation']['validation_error_movie_year'] ?? '';
                                $validation_error_description = $_SESSION['validation']['validation_error_description'] ?? '';
                                unset($_SESSION['validation']);
                            }
                            ?>
                            <form id="myForm" action="../upload_movie_module/upload_process/proceed_step1.php"
                                method="post">
                                <div class="row mb-3">
                                    <label for="name" class="col-sm-4 col-form-label">Movie name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="name" id="name"
                                            value="<?= $name ?>">
                                        <?php
                                        if ($validation_error_name) {
                                            ?>
                                            <div class="text-primary error-message" id="errorMessage">
                                                <?= $validation_error_name ?>
                                            </div>
                                            <script>
                                                let element = document.getElementById('name');
                                                const errorMessage = document.getElementById('errorMessage');

                                                shake(element, errorMessage);
                                            </script>
                                            <?php
                                        }

                                        if (isset($_SESSION['alreadyExists'])) {
                                            ?>
                                            <div class="text-primary error-message" id="errorMessageAlreadyExixts">
                                                <?= $_SESSION['alreadyExists'] ?>
                                            </div>
                                            <script>
                                                let nameAlreadyExistsName = document.getElementById('name');
                                                const errorMessageExist = document.getElementById('errorMessageAlreadyExixts');

                                                shake(nameAlreadyExistsName, errorMessageExist);
                                            </script>
                                            <?php
                                            unset($_SESSION['alreadyExists']);
                                        }
                                        ?>
                                        <span id="nameError" class="error-message"
                                            style="color: red; display: none;">Please enter valid name</span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="duration_minute" class="col-sm-4 col-form-label">Duration <small>(in
                                            minutes)</small></label>
                                    <div class="col-sm-8">
                                        <input type="text" name="duration_minute" class="form-control"
                                            id="duration_minute" value="<?= $duration_minute ?>">
                                        <?php
                                        if ($validation_error_duration_minute) {
                                            ?>
                                            <div class="text-primary error-message" id="errorMessage">
                                                <?= $validation_error_duration_minute ?>
                                            </div>
                                            <script>
                                                let element = document.getElementById('duration_minute');
                                                const errorMessage = document.getElementById('errorMessage');

                                                shake(element, errorMessage);
                                            </script>
                                            <?php
                                        }
                                        ?>
                                        <span id="duration_minuteError" class="error-message"
                                            style="color: red; display: none;">Please enter valid duration.</span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="movie_year" class="col-sm-4 col-form-label">Release Year
                                        <small>(ex:2025)</small></label>
                                    <div class="col-sm-8">
                                        <!-- <input type="text" class="form-control" id="movie_year" name="movie_year"> -->
                                        <select id="movie_year" class="form-select" name="movie_year">

                                        </select>
                                        <?php
                                        if ($validation_error_movie_year) {
                                            ?>
                                            <div class="text-primary error-message" id="errorMessage">
                                                <?= $validation_error_movie_year ?>
                                            </div>
                                            <script>
                                                let element = document.getElementById('movie_year');
                                                const errorMessage = document.getElementById('errorMessage');

                                                shake(element, errorMessage);
                                            </script>
                                            <?php
                                        }
                                        ?>
                                        <span id="movie_yearError" class="error-message"
                                            style="color: red; display: none;">Please select movie is paid or
                                            not.</span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="description" class="col-sm-4 col-form-label">Description <small><span
                                                id="counter_description">0</span>/255</small></label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="description" id="description"
                                            onkeypress="checklenght()"><?= $description ?></textarea>
                                        <?php
                                        if ($validation_error_description) {
                                            ?>
                                            <div class="text-primary error-message" id="errorMessage">
                                                <?= $validation_error_description ?>
                                            </div>
                                            <script>
                                                let element = document.getElementById('description');
                                                const errorMessage = document.getElementById('errorMessage');

                                                shake(element, errorMessage);
                                            </script>
                                            <?php
                                        }
                                        ?>
                                        <span id="descriptionError" class="error-message"
                                            style="color: red; display: none;">Enter valid description of movie.</span>
                                        <span id="errorDescription" class="text-primary"></span>
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
<script src="../../common/js/shake.js"></script>
<script>

    $("#myForm").submit(function (event) {
        let valid = true;

        // Reset previous error messages
        $(".error-message").hide();


        let name = $("#name").val().trim();
        // Check if the isFree is selected
        if ($("#name").val().trim() === "" ||
            !/^[a-zA-Z0-9]/.test(name) ||
            !/[a-zA-Z]/.test(name) ||
            /[^a-zA-Z0-9\s]{2,}/.test(name) ||
            !/^[a-zA-Z0-9\s\-\'",.!?&:]+$/.test(name)
        ) {
            let nameElement = document.getElementById('name');
            let nameError = document.getElementById('nameError');
            shake(nameElement, nameError);
            valid = false;
        }

        // Get the duration value as a number
        let duration = parseInt($("#duration_minute").val(), 10);

        // Check if duration is empty, not a number, negative, or less than 30
        if (isNaN(duration) || !(duration > 10) || !(duration < 240)) {
            valid = false;
            let multipleselectfield = document.getElementById('duration_minute');
            let selectedTagError = document.getElementById('duration_minuteError');
            selectedTagError.textContent = "Duration must be between 10 and 600 minutes";
            shake(multipleselectfield, selectedTagError);
        }


        // Check if the rating is selected
        if ($("#movie_year").val() === "") {
            let age_rating = document.getElementById('movie_year');
            let age_ratingError = document.getElementById('movie_yearError');
            shake(age_rating, age_ratingError);
            valid = false;
        }

        // Check if the studio field is empty
        if ($("#description").val().trim() === "") {
            let production_studio = document.getElementById('description');
            let studioError = document.getElementById('descriptionError');
            shake(production_studio, studioError);
            valid = false;
        }

        // Prevent form submission if validation fails
        if (!valid) {
            event.preventDefault();
        }
    });

</script>

<script>
    function checkLength() {
        var text = document.getElementById("description").value.trim();
        var counterElement = document.getElementById("counter_description");
        var counter = text.length; // Using .length directly since we want all characters

        // Update counter display
        counterElement.innerHTML = counter;

        // Check if limit exceeded
        if (counter > 255) {
            counterElement.classList.remove("text-success");
            counterElement.classList.add("text-danger"); // Using danger color for exceeded limit
            document.getElementById("errorDescription").innerHTML = "Maximum 255 characters allowed";

            // Optionally truncate the text if you want to enforce the limit
            // document.getElementById("description").value = text.substring(0, 255);
        } else {
            counterElement.classList.remove("text-primary", "text-danger");
            counterElement.classList.add("text-success");
            document.getElementById("errorDescription").innerHTML = "";
        }
    }

    // Add event listeners for all relevant input events
    document.getElementById("description").addEventListener('input', checkLength);
    document.getElementById("description").addEventListener('keydown', function (e) {
        // Immediate feedback for backspace/delete
        if (e.key === 'Backspace' || e.key === 'Delete') {
            setTimeout(checkLength, 0); // Small delay to allow the key to take effect
        }
    });
    document.getElementById("description").addEventListener('paste', function () {
        setTimeout(checkLength, 0); // Handle paste operations
    });
</script>

<script>
    function loadYears() {
        const currentYear = new Date().getFullYear();
        const yearDropdown = document.getElementById('movie_year');

        let defaultYear = "<?= $movie_year ?>"; // Ensure this is correctly set from PHP
        defaultYear = parseInt(defaultYear) || 0; // Ensure it's a number

        // Clear existing options if any
        yearDropdown.innerHTML = "";

        // Populate dropdown with years from 1900 to the current year
        for (let year = currentYear; year >= 1900; year--) {
            const option = document.createElement('option');
            option.value = year;
            option.textContent = year;

            if (year === defaultYear) {
                option.selected = true;
            }

            yearDropdown.appendChild(option);
        }
    }

</script>

<script>
    function loadBody() {
        const sidebar_title = document.getElementById('movies');
        sidebar_title.click();
        loadYears();
        acivateSideBar(document.getElementById('pending_movie'));
        acivateSideBar(sidebar_title);
    }
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