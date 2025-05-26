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
    <title>CineVision | Add Movie</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <?php
    // including css
    include("../common/css/style.html");
    ?>
    <link rel="stylesheet" href="../../common/style/warning_alert.css">
    <link rel="stylesheet" href="../../common/style/shake.css">
    <script src="../../common/js/shake.js"></script>
    <style>
        .error-message {
            font-size: 13px;
        }
    </style>

    <?php
    if (isset($_SESSION['serverError'])) {
        ?>
        <script>
            showErrorNotification(<?= $_SESSION['serverError'] ?>, 5000);
        </script>
        <?php
        unset($_SESSION['serverError']);
    }
    ?>
</head>

<body onload="loadBody()">
    <?php
    $alreadyExists = $_SESSION['alredyExists'] ?? '';
    $validationError_name = $_SESSION['validation']['validation_error_name'] ?? '';
    $validationError_desc = $_SESSION['validation']['validation_error_desc'] ?? '';
    $validationError_year = $_SESSION['validation']['validation_error_year'] ?? '';
    $validationError_duration = $_SESSION['validation']['validation_error_duration'] ?? '';
    unset($_SESSION['alredyExists'], $_SESSION['validation']);
    ?>
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
        // including sidebar
        include("../common/sidebar.php");
        ?>


        <!-- Content Start -->
        <div class="content" id="content">
            <?php
            // including header
            include("../common/header.php");
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

            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">

                    <ul class="nav nav-pills" style="border-bottom:5px solid red">
                        <li class="nav-item">
                            <div class="nav-link active " style="border-radius : 20px 20px 0 0 !important;">
                                Besic Detail(
                                <span class="status">Current</span>)
                            </div>
                        </li>
                        <li class="nav-item"
                            onclick="showErrorNotification('Please fill up basic details first',4000);">
                            <div class="nav-link text-body">
                                Movie Detail(
                                <span class="status text-primary">Pending</span>)
                            </div>
                        </li>
                        <li class="nav-item"
                            onclick="showErrorNotification('Please fill up basic details first',4000);">
                            <div class="nav-link  text-body">
                                Add Cast(
                                <span class="status text-primary">Pending</span>)
                            </div>
                        </li>
                        <li class="nav-item"
                            onclick="showErrorNotification('Please fill up basic details first',4000);">
                            <div class="nav-link  text-body">
                                Photo(
                                <span class="status text-primary">Pending</span>)
                            </div>
                        </li>
                        <li class="nav-item"
                            onclick="showErrorNotification('Please fill up basic details first',4000);">
                            <div class="nav-link  text-body">
                                Movie(
                                <span class="status text-primary">Pending</span>)
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded p-4">
                            <h4 class="mb-4 text-info">Basic Details</h4>
                            <form action="../upload_movie_module/upload_process/insert_movie.php" method="post"
                                id="myForm">
                                <div class="row mb-3">
                                    <label for="name" class="col-sm-4 col-form-label">Movie name<span
                                            style="color:red;font-size:10px"> *</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="name" id="name"
                                            value="<?= $_SESSION['form_data']['name'] ?? '' ?>">
                                        <span id="nameError" class="error-message"
                                            style="color: red; display: none;">Please enter valid name</span>
                                        <?php
                                        if ($alreadyExists) {
                                            ?>
                                            <div class="text-primary error-message" id="errorMessage"><?= $alreadyExists ?>
                                            </div>
                                            <script>
                                                let element = document.getElementById('name');
                                                const errorMessage = document.getElementById('errorMessage');

                                                shake(element, errorMessage);
                                            </script>
                                            <?php
                                        }
                                        if ($validationError_name) {
                                            ?>
                                            <div class="text-primary error-message" id="errorMessage">
                                                <?= $validationError_name ?>
                                            </div>
                                            <script>
                                                let element = document.getElementById('name');
                                                const errorMessage = document.getElementById('errorMessage');

                                                shake(element, errorMessage);
                                            </script>
                                            <?php
                                        }

                                        ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="duration_minute" class="col-sm-4 col-form-label">Duration <small>(in
                                            minutes)</small><span style="color:red;font-size:10px"> *</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" name="duration_minute" class="form-control"
                                            id="duration_minute"
                                            value="<?= $_SESSION['form_data']['duration_minute'] ?? '' ?>">
                                        <span id="durationError" class="error-message"
                                            style="color: red; display: none;">Please enter Duration of movie.(in
                                            minute)</span>
                                        <?php
                                        if ($validationError_duration) {
                                            ?>
                                            <div class="text-primary error-message" id="errorMessage">
                                                <?= $validationError_duration ?>
                                            </div>
                                            <script>
                                                let element = document.getElementById('duration_minute');
                                                const errorMessage = document.getElementById('errorMessage');

                                                shake(element, errorMessage);
                                            </script>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="movie_year" class="col-sm-4 col-form-label">Release Year<span
                                            style="color:red;font-size:10px"> *</span></label>
                                    <div class="col-sm-8">
                                        <!-- <input type="text" class="form-control" id="movie_year" name="movie_year"> -->
                                        <select id="movie_year" class="form-select" name="movie_year">
                                            <option value=" 
                                            " selected disabled>Select year</option>
                                        </select>
                                        <span id="yearError" class="error-message"
                                            style="color: red; display: none;">Please select valid year.</span>
                                        <?php
                                        if ($validationError_year) {
                                            ?>
                                            <div class="text-primary error-message" id="errorMessage">
                                                <?= $validationError_year ?>
                                            </div>
                                            <script>
                                                let element = document.getElementById('movie_year');
                                                const errorMessage = document.getElementById('errorMessage');

                                                shake(element, errorMessage);
                                            </script>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="description" class="col-sm-4 col-form-label">Description <small><span
                                                id="counter_description">0</span>/255</small><span
                                            style="color:red;font-size:10px"> *</span></label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="description" id="description"
                                            onkeyup="checklenght()"><?= $_SESSION['form_data']['description'] ?? '' ?></textarea>
                                        <span id="descError" class="error-message"
                                            style="color: red; display: none;">Please enter description(more then 10
                                            character).</span>
                                        <?php
                                        if ($validationError_desc) {
                                            ?>
                                            <div class="text-primary error-message" id="errorMessage">
                                                <?= $validationError_desc ?>
                                            </div>
                                            <script>
                                                let element = document.getElementById('description');
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
            unset($_SESSION['form_data']);
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
        const sidebar_title = document.getElementById('movies');
        sidebar_title.click();

        //for load years in select box (user input)
        loadYears();

        acivateSideBar(document.getElementById('add_movie'));
        acivateSideBar(sidebar_title);
    }
</script>
<script>
    function loadYears() {

        const currentYear = new Date().getFullYear();

        // Reference to dropdown and search input
        const yearDropdown = document.getElementById('movie_year');
        const yearSearch = document.getElementById('movie_year');

        // Populate dropdown with years from 1900 to current year
        for (let year = currentYear; year >= 1900; year--) {
            const option = document.createElement('option');
            option.value = year;
            option.textContent = year;
            yearDropdown.appendChild(option);
        }

    }
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
<script src="../../common/js/warning_alert.js"></script>

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

</html>