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
    <title>CineVision | Draft Movie</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <?php
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
        <?php include("../common/sidebar.php"); ?>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content" id="content">
            <!-- Navbar Start -->
            <?php include("../common/header.php"); ?>
            <!-- Navbar End -->

            <div class="container-fluid pt-4 px-4" id="loading">
                <div class="bg-secondary rounded-top" style="height:70vh;">
                    <h4 class="mb-2 text-info p-4">Released movie</h4>
                    <div class="col-sm-12 col-xl-12" style="overflow-y:scroll; height:50vh">
                        <div class="bg-secondary rounded h-100">
                            <div class="container-fluid pt-2 px-2">
                                <div class="bg-secondary text-center rounded ps-2 pe-2">

                                    <!-- Search Box -->
                                    <div class="mb-3">
                                        <input type="text" id="searchInput" class="form-control"
                                            placeholder="Search by Movie Name" onkeyup="filterTable()">
                                    </div>

                                    <div class="table-responsive">
                                        <table id="movieTable"
                                            class="table text-start align-middle table-bordered table-hover mb-0">
                                            <thead>
                                                <tr class="text-white">
                                                    <th scope="col">No.</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Release year</th>
                                                    <th scope="col">Available for client</th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col">Edit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                include('../../common/connection/connection.php');
                                                date_default_timezone_set("Asia/Kolkata");

                                                $selectQuery = "SELECT id , name , movie_year , description , upload_from FROM movie WHERE movie_status=1";
                                                $selectStmt = $pdo->prepare($selectQuery);
                                                $selectStmt->execute();

                                                if ($selectStmt->rowCount() > 0) {
                                                    $movies = $selectStmt->fetchAll(PDO::FETCH_ASSOC);
                                                    $counter = 1;
                                                    foreach ($movies as $movie) {
                                                        $uniqueId = "countdown_" . $movie['id'];
                                                        $uploadFrom = $movie['upload_from'];
                                                        ?>
                                                        <tr>
                                                            <td><?= $counter++ ?></td>
                                                            <td><?= $movie['name'] ?></td>
                                                            <td><?= $movie['movie_year'] ?></td>
                                                            <td>
                                                                <div id="<?= $uniqueId ?>" data-release="<?= $uploadFrom ?>"></div>
                                                            </td>
                                                            <td><?= $movie['description'] ?></td>
                                                            <td>
                                                                <center><a href="step1.php?movieId=<?= $movie['id'] ?>"><i class="fas fa-edit"></i></a></center>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Start -->
            <?php include("../common/footer.php"); ?>
            <!-- Footer End -->
        </div>
        <!-- Content End -->

        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <?php include("../common/js/script.html"); ?>
</body>

<script>
    function loadBody() {
        const sidebar_title = document.getElementById('movies');
        sidebar_title.click();

        acivateSideBar(document.getElementById('uploaded_movie'));
        acivateSideBar(sidebar_title);
    }

    // Filter function for search box
    function filterTable() {
        const searchValue = document.getElementById('searchInput').value.toLowerCase();
        const table = document.getElementById('movieTable');
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const movieNameCell = rows[i].getElementsByTagName('td')[1];
            if (movieNameCell) {
                const movieName = movieNameCell.textContent || movieNameCell.innerText;
                rows[i].style.display = movieName.toLowerCase().includes(searchValue) ? '' : 'none';
            }
        }
    }

    // Countdown logic for each movie
    document.addEventListener('DOMContentLoaded', function () {
        const countdowns = document.querySelectorAll('[id^="countdown_"]');

        countdowns.forEach(div => {
            const releaseTimeStr = div.getAttribute('data-release');
            const releaseTime = new Date(releaseTimeStr).getTime();

            function updateCountdown() {
                const now = new Date().getTime();
                const diff = releaseTime - now;

                if (diff <= 0) {
                    div.innerHTML = "Released";
                    return;
                }

                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = String(Math.floor((diff / (1000 * 60 * 60)) % 24)).padStart(2, '0');
                const minutes = String(Math.floor((diff / (1000 * 60)) % 60)).padStart(2, '0');
                const seconds = String(Math.floor((diff / 1000) % 60)).padStart(2, '0');

                let output = "";
                if (days > 0) {
                    output += `${days}d `;
                }
                output += `${hours}:${minutes}:${seconds}`;
                div.innerHTML = output;
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        });
    });
</script>

</html>
