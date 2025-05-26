<?php
session_start();
if (isset($_POST['name']) && strlen(trim($_POST['name'])) > 2) {
    if (isset($_POST['duration_minute']) && strlen(trim($_POST['duration_minute'])) > 1) {
        if (isset($_POST['movie_year']) && $_POST['movie_year'] <= date('Y')) {
            if (isset($_POST['description']) && strlen(trim($_POST['description'])) > 1) {

                include("../../../common/connection/connection.php");
                $selectQuery = "SELECT id FROM movie WHERE name=? AND movie_year=?";
                $selectStmt = $pdo->prepare($selectQuery);

                $selectStmt->execute([
                    $_POST['name'],
                    $_POST['movie_year']
                ]);
                if ($selectStmt->rowCount() > 0) {

                    $_SESSION['alredyExists'] = "The " . $_POST['name'] . " movie in " . $_POST['movie_year'] . " is already posted";
                    $_SESSION['form_data'] = $_POST;
                    header("location:../../dashboard_module/add_movie.php");

                } else {

                    $insertQuery = "INSERT INTO movie (name , movie_year , duration_minute , description)
                    VALUES (?,?,?,?)";

                    $insertStmt = $pdo->prepare($insertQuery);
                    $insertStmt->execute(
                        [
                            $_POST['name'],
                            $_POST['movie_year'],
                            $_POST['duration_minute'],
                            $_POST['description'],
                        ]
                    );
                    if ($insertStmt->rowCount() == 1) {
                        $_SESSION['success'] = "Movie's Basic detail uploaded";
                        $insertedId = $pdo->lastInsertId();
                        include("../../common/function.php");
                        createMovieDirectory($insertedId);

                        header("location:../../dashboard_module/step2.php?movieId=" . $insertedId);
                    } else {
                        $_SESSION['serverError'] = "Error in Movie upload !";
                        $insertedId = $pdo->lastInsertId();
                        header("location:../../dashboard_module/step2.php?movieId=" . $insertedId);
                    }
                }

            } else {
                // echo "description";
                $_SESSION['validation']['validation_error_desc'] = "Enter valid description";
                //session managed
                $_SESSION['form_data'] = $_POST;
                header('location:../../dashboard_module/add_movie.php');
            }
        } else {
            // echo "minutes";
            //session managed
            $_SESSION['form_data'] = $_POST;

            $_SESSION['validation']['validation_error_year'] = "Enter valid year";
            header('location:../../dashboard_module/add_movie.php');
        }
    } else {
        // echo "duration";
        //session managed
        $_SESSION['form_data'] = $_POST;

        $_SESSION['validation']['validation_error_duration'] = "Enter valid time duration";
        header('location:../../dashboard_module/add_movie.php');
    }
} else {
    // echo "Enter valid name";
    //session managed
    $_SESSION['form_data'] = $_POST;

    $_SESSION['validation']['validation_error_name'] = "Enter valid name";
    header('location:../../dashboard_module/add_movie.php');
}
?>