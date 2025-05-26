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
    <title>CineVision | Upload Movie</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Styles -->
    <?php
    if (isset($_SESSION['success'])) {
        ?>
        <link rel="stylesheet" href="../../common/style/sweet_alert.css">

        <?php
    }

    ?>
    <link rel="stylesheet" href="../../common/style/warning_alert.css">

    <?php
    // including css
    include("../common/css/style.html");
    ?>
    <!-- Styles -->
    <style>
        .rounded-image {
            width: 150px;
            /* Set desired size */
            height: 150px;
            border-radius: 50%;
            /* Makes the image circular */
            object-fit: cover;
            /* Prevents image stretching */
            overflow: hidden;
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
        // sidebar start
        include("../common/sidebar.php");
        //sidebar end
        ?>

        <!-- Content Start -->
        <div class="content" id="content">

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

            <!-- Navbar Start -->
            <?php include("../common/header.php"); ?>
            <!-- Navbar End -->

            <?php //this will included at run time 
            ?>
            <?php


            ?>
            <link rel="stylesheet" href="css/customSelectBox.css">


            <?php
            include("../common/function.php");
            getMovieProgressStep($_SESSION['movieId'], 3);

            ?>
            <!-- Progress list end -->

            <div class="container-fluid pt-4 px-4" id="loading">
                <div class="bg-secondary rounded-top">
                    <h4 class="mb-2 text-info p-4">Add cast</h4>
                    <div class="col-sm-12 col-xl-12" style="overflow-y:scroll; height:50vh">
                        <div class="bg-secondary rounded h-100">

                            <div class="container-fluid pt-2 px-2">
                                <div class="bg-secondary text-center rounded p-4">

                                    <div class="table-responsive">
                                        <table id="personTable"
                                            class="table text-start align-middle table-bordered table-hover mb-0">
                                            <thead>
                                                <tr class="text-white">
                                                    <th scope="col">No.</th>
                                                    <th scope="col">Image</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Role</th>
                                                    <th scope="col">Delete</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $counter = 1;
                                            include('../../common/connection/connection.php');
                                            $selectData = "SELECT mc.id,p.name, p.image, r.name AS role_name 
                                                            FROM movie_cast mc
                                                            JOIN person p ON mc.person_id = p.id
                                                            JOIN role r ON mc.role_id = r.id 
                                                            WHERE mc.movie_id = ?";
                                            $stmt = $pdo->prepare($selectData);
                                            $stmt->execute([$movieID]);

                                            $stmt->execute();
                                            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            ?>
                                            <tbody>
                                                <?php
                                                if ($stmt->rowCount() > 0) {


                                                    foreach ($users as $user) {
                                                        ?>
                                                        <tr id="row_<?= $user['id'] ?>">
                                                            <td class="counter"><?= $counter++ ?></td>
                                                            <td>
                                                                <center><img
                                                                        src="../../uploads/cast_pic/<?php echo $user['image'] ?>"
                                                                        alt="<?= $user['name'] ?>" class="rounded-image me-lg-3"
                                                                        style="height:50px;width:50px;cursor:pointer"
                                                                        onclick="showImage(this.src,this.alt)"
                                                                        data-bs-toggle="modal" data-bs-target="#photoModal">
                                                                </center>
                                                            </td>
                                                            <td><?= $user['name'] ?></td>
                                                            <td><?= $user['role_name'] ?></td>
                                                            <td>
                                                                <center>
                                                                    <button class="btn btn-sm btn-primary"
                                                                        onclick="deleteRow(<?= $user['id'] ?>)">
                                                                        Delete
                                                                    </button>
                                                                </center>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <tr>
                                                        <td>0</td>
                                                        <td>no any cast</td>
                                                        <td>no any cast</td>
                                                        <td>no any cast</td>
                                                        <td>no any cast</td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>

                                        </table>

                                    </div>
                                </div>
                            </div>


                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="insert_cast.php" method="POST" enctype="multipart/form-data">
                                            <div class="modal-header bg-secondary">
                                                <h1 class="modal-title fs-5 text-primary" id="exampleModalLabel">Add New
                                                    Cast</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body bg-secondary">
                                                <div class="bg-secondary rounded h-100 p-4">
                                                    <!-- Select Person -->
                                                    <div class="mb-3">
                                                        <label for="person_id" class="form-label">Select Person</label>
                                                        <div class="custom-select bg-secondary">
                                                            <div class="selected-option bg-secondary">Select Person
                                                            </div>
                                                            <input type="text"
                                                                class="search-box bg-secondary text-primary"
                                                                placeholder="Search..." />
                                                            <div class="options bg-secondary">
                                                                <?php
                                                                $selectPersons = "SELECT * FROM person";
                                                                $selectPersonsStmt = $pdo->prepare($selectPersons);
                                                                $selectPersonsStmt->execute();
                                                                $persons = $selectPersonsStmt->fetchAll(PDO::FETCH_ASSOC);
                                                                foreach ($persons as $person) {
                                                                    ?>
                                                                    <div class="option" data-value="<?= $person['id']; ?>">
                                                                        <img src="../../uploads/cast_pic/<?= $person['image'] ?>"
                                                                            style="height:40px;width:40px;"
                                                                            alt="Image of person">
                                                                        <span><?= $person['name']; ?></span>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" id="person_id" name="person_id">
                                                    </div>

                                                    <!-- Select Role -->
                                                    <div class="mb-3">
                                                        <label for="role_id" class="form-label">Select Role</label>
                                                        <select name="role_id" id="role_id" class="form-select">
                                                            <?php
                                                            $selectRoles = "SELECT * FROM role";
                                                            $selectRoleStmt = $pdo->prepare($selectRoles);
                                                            $selectRoleStmt->execute();
                                                            $roles = $selectRoleStmt->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach ($roles as $role) {
                                                                ?>
                                                                <option value="<?= $role['id']; ?>"><?= $role['name']; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer bg-secondary">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        style="display:flex;justify-content:space-around;border-top:5px solid red;border-radius:7px;padding:15px">
                        <center>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Add new Cast
                            </button>
                        </center>
                        <a class="btn btn-primary" href="step4.php?movieId=<?= $_SESSION['movieId']; ?>">Go to next page</a>
                    </div>
                </div>
            </div>

            <!-- for show photo on screen -->
            <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="insert_cast.php" method="POST" enctype="multipart/form-data">
                            <div class="modal-header bg-secondary">
                                <h1 class="modal-title fs-5 text-primary" id="nameOfCast">Image of cast</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body bg-secondary">
                                <div class="bg-secondary rounded h-100 p-4">
                                    <img src="" alt="" id="modalPhoto"><!-- Select Person -->
                                </div>
                            </div>

                            <div class="modal-footer bg-secondary">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
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
<script src="js/customSelectBox.js"></script>


<script>
    function loadBody() {
        const sidebar_title = document.getElementById('movies');
        sidebar_title.click();

        acivateSideBar(document.getElementById('pending_movie'));
        acivateSideBar(sidebar_title);
    }
</script>
<script>
    function deleteRow(rowId) {
        if (confirm("Are you sure you want to delete this cast?")) {
            $.ajax({
                url: 'removeCast.php',
                type: 'POST',
                data: { id: rowId },
                success: function (response) {
                    if (response === 'ONE CAST ONLY') {
                        showErrorNotification("At least 1 cast is needed in movie data",5000);
                    }
                    else if (response === 'success') {
                        // Remove the row
                        $("#row_" + rowId).remove();
                        // Update the row numbers
                        updateRowCounters();
                    } else {
                        alert('Failed to delete row.');
                    }
                },
                error: function () {
                    alert('Error while deleting row.');
                }
            });
        }
    }

    function updateRowCounters() {
        $('#personTable tbody tr').each(function (index) {
            $(this).find('.counter').text(index + 1);
        });
    }
</script>
<script>
    function showImage(path, altAttribute) {
        const modalPhoto = document.getElementById('modalPhoto');
        modalPhoto.src = path;

        const nameOfCast = document.getElementById('nameOfCast');
        nameOfCast.innerHTML = altAttribute;
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

<script src="../../common/js/warning_alert.js"></script>
<?php
if (isset($_SESSION['serverError'])) {
    ?>
    <script>
        showErrorNotification("<?= $_SESSION['serverError'] ?>", 5000);
    </script>
    <?php
    unset($_SESSION['serverError']);
}