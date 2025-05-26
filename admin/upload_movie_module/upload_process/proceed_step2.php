<?php
session_start();
if (isset($_SESSION['movieId'])) {
    if (isset($_POST['isFree']) && ($_POST['isFree'] == '1' || $_POST['isFree'] == '0')) {
        if (isset($_POST['tags']) && count($_POST['tags']) >= 1) {
            if (isset($_POST['age_rating']) && strlen(trim($_POST['age_rating'])) >= 1) {
                if (isset($_POST['production_studio']) && strlen(trim($_POST['production_studio'])) >= 2) {

                    include("../../../common/connection/connection.php");
                    $updateQuery = "UPDATE movie SET isFree= :isFree ,tags = :tags , age_rating = :age_rating , production_studio = :production_studio WHERE id = :id ";
                    $updateStmt = $pdo->prepare($updateQuery);

                    $tags = implode(" | ", $_POST['tags']);
                    $updateStmt->bindParam(':isFree' , $_POST['isFree'] , PDO::PARAM_STR);
                    $updateStmt->bindParam(':tags' ,  $tags , PDO::PARAM_STR);
                    $updateStmt->bindParam(':age_rating' , $_POST['age_rating'] , PDO::PARAM_STR);
                    $updateStmt->bindParam(':production_studio' , $_POST['production_studio'] , PDO::PARAM_STR);
                    $updateStmt->bindParam(':id' , $_SESSION['movieId'] , PDO::PARAM_STR);
                    
                    if ($updateStmt->execute()) {
                        include("../../common/updateStep.php");
                        updateStep($_SESSION['movieId'],"step2",$pdo);
                        $_SESSION['success'] = "Movie details updated !";
                        header("location:../../dashboard_module/step3.php?movieId=" . $_SESSION['movieId']);

                    } else {
                        $_SESSION['serverError'] = "Failed to update Movie details , Please try again !";

                        $_SESSION['form_data'] = $_POST;
                        header("location:../../dashboard_module/step2.php?movieId= ". $_SESSION['movieId']);
                    }

                } else {
                    // echo "description";
                    $_SESSION['validation']['validation_error_production_studio'] = "Enter valid production studio";
                    //session managed
                    $_SESSION['form_data'] = $_POST;
                    header('location:../../dashboard_module/step2.php?movieId=' . $_SESSION['movieId']);
                }
            } else {
                // echo "minutes";
                //session managed
                $_SESSION['form_data'] = $_POST;

                $_SESSION['validation']['validation_error_age_rating'] = "Select valid Age rating";
                header('location:../../dashboard_module/step2.php?movieId=' . $_SESSION['movieId']);
            }
        } else {
            // echo "duration";
            //session managed
            $_SESSION['form_data'] = $_POST;

            $_SESSION['validation']['validation_error_tags'] = "Enter valid tags(select at least 1).";
            header('location:../../dashboard_module/step2.php?movieId=' . $_SESSION['movieId']);
        }
    } else {
        // echo "Enter valid user";
        //session managed
        $_SESSION['form_data'] = $_POST;

        $_SESSION['validation']['validation_error_isFree'] = "Enter valid users";
        header('location:../../dashboard_module/step2.php?movieId=' . $_SESSION['movieId']);
    }
} else {
    $_SESSION['serverError'] = "Select movie";
    header('location:../../dashboard_module/pending_movie.php');
}
?>