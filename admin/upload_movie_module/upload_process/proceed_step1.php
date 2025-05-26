<?php
session_start();
if (isset($_SESSION['movieId'])) {
    if (isset($_POST['name']) && strlen(trim($_POST['name'])) > 2) {
        if (isset($_POST['duration_minute']) && strlen(trim($_POST['duration_minute'])) > 1) {
            if (isset($_POST['movie_year']) && $_POST['movie_year'] <= date('Y')) {
                if (isset($_POST['description']) && strlen(trim($_POST['description'])) > 1) {

                    include("../../../common/connection/connection.php");


                    $selectQuery = "SELECT name,movie_year,duration_minute,description FROM movie WHERE id=?";
                    $selectStmt = $pdo->prepare($selectQuery);

                    $selectStmt->execute([
                        $_SESSION['movieId']
                    ]);
                    //no need to check wather this movie found or not (because previous page will never allow to come here)
                    $movieData = $selectStmt->fetch(PDO::FETCH_ASSOC);
                    $isDataUnchanged = $movieData['name'] == $_POST['name'] &&
                        $movieData['movie_year'] == $_POST['movie_year'] &&
                        $movieData['duration_minute'] == $_POST['duration_minute'] &&
                        $movieData['description'] == $_POST['description'];
                    if ($isDataUnchanged) {
                        $_SESSION['success'] = "Basic detail updated";
                        header("location:../../dashboard_module/step2.php?movieId=" . $_SESSION['movieId']);
                    } else {
                        if ($movieData['name'] == $_POST['name'] && $movieData['movie_year'] == $_POST['movie_year']) {
                            //then allow for update
                            $updateQuery = "UPDATE movie SET duration_minute = ? , description = ? WHERE id = ? ";
                            $updateStmt = $pdo->prepare($updateQuery);

                            $updateStmt->execute([
                                $_POST['duration_minute'],
                                $_POST['description'],
                                $_SESSION['movieId']
                            ]);
                            if ($updateStmt->rowCount() == 1) {

                                $_SESSION['success'] = "Basic detail updated";
                                header("location:../../dashboard_module/step2.php?movieId=" . $_SESSION['movieId']);

                            } else {

                                $_SESSION['serverError'] = "Failed to update data";

                                $_SESSION['form_data'] = $_POST;
                                header("location:../../dashboard_module/step1.php?movieId=" . $_SESSION['movieId']);
                            }
                        } else {
                            //check in database is new record get duplicate with old one
                            $selectQueryLevel2 = "SELECT name,movie_year FROM movie WHERE name=? AND movie_year=?";
                            $selectStmtLevel2 = $pdo->prepare($selectQueryLevel2);

                            $selectStmtLevel2->execute([
                                $_POST['name'],
                                $_POST['movie_year']
                            ]);

                            if ($selectStmtLevel2->rowCount() == 0) {
                                $updateQueryWithNameYear = "UPDATE movie SET name=? , movie_year=? , duration_minute = ? , description = ? WHERE id = ? ";
                                $updateStmtWithNameYear = $pdo->prepare($updateQueryWithNameYear);

                                $updateStmtWithNameYear->execute([
                                    $_POST['name'],
                                    $_POST['movie_year'],
                                    $_POST['duration_minute'],
                                    $_POST['description'],
                                    $_SESSION['movieId']
                                ]);

                                if ($updateStmtWithNameYear->rowCount() == 1) {
                                    $_SESSION['success'] = "Basic detail updated";
                                    header("location:../../dashboard_module/step2.php?movieId=" . $_SESSION['movieId']);
                                } else {
                                    $_SESSION['serverError'] = "Failed to update data";

                                    $_SESSION['form_data'] = $_POST;
                                    header("location:../../dashboard_module/step1.php?movieId=" . $_SESSION['movieId']);
                                }
                            } else {
                                $_SESSION['alreadyExists'] = "The " . $_POST['name'] . " movie in " . $_POST['movie_year'] . " is already posted";
                                $_SESSION['form_data'] = $_POST;
                                header("location:../../dashboard_module/step1.php?movieId=" . $_SESSION['movieId']);
                            }

                        }
                    }




                } else {
                    // echo "description";
                    $_SESSION['validation']['validation_error_description'] = "Enter valid description";
                    //session managed
                    $_SESSION['form_data'] = $_POST;
                    header('location:../../dashboard_module/step1.php?movieId=' . $_SESSION['movieId']);
                }
            } else {
                // echo "minutes";
                //session managed
                $_SESSION['form_data'] = $_POST;

                $_SESSION['validation']['validation_error_movie_year'] = "Enter valid year";
                header('location:../../dashboard_module/step1.php?movieId=' . $_SESSION['movieId']);
            }
        } else {
            // echo "duration";
            //session managed
            $_SESSION['form_data'] = $_POST;

            $_SESSION['validation']['validation_error_duration_minute'] = "Enter valid time duration";
            header('location:../../dashboard_module/step1.php?movieId=' . $_SESSION['movieId']);
        }
    } else {
        // echo "Enter valid name";
        //session managed
        $_SESSION['form_data'] = $_POST;

        $_SESSION['validation']['validation_error_name'] = "Enter valid name";
        header('location:../../dashboard_module/step1.php?movieId=' . $_SESSION['movieId']);
    }
} else {
    $_SESSION['serverError'] = "Select movie";
    header('location:../../dashboard_module/pending_movie.php');
}
?>