<?php
session_start();

if (isset($_POST['name']) && strlen($_POST['name']) >= 2 && isset($_FILES['image'])) {

    $image_type = $_FILES['image']['type'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];

    $acceptedPhotoSize = 1024 * 1024 * 3;
    $pathToUpload = '../../../uploads/cast_pic/';

    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        if ($_FILES['image']['size'] < $acceptedPhotoSize) {//3 MB file accepted
            if ($_FILES['image']['type'] == "image/jpeg" || $_FILES['image']['type'] == "image/jpg" || $_FILES['image']['type'] == "image/png") {
                $newName = uniqid("IMG-",true).".jpg";
                $pathWithImage = $pathToUpload . $newName;
                if(move_uploaded_file($image_tmp_name,$pathWithImage)){
                    // echo "Image moved";
                    include('../../../common/connection/connection.php');
                    $insertQuery = "INSERT INTO person (name , image) VALUES (:name,:image)";
                    $insertStmt = $pdo->prepare($insertQuery);

                    $insertStmt->bindParam(":name",$_POST['name'],PDO::PARAM_STR);
                    $insertStmt->bindParam(":image",$newName,PDO::PARAM_STR);

                    if($insertStmt->execute()){
                        $_SESSION['success']="Person added !";
                        header("location:../add_people.php");
                    }else{
                        unlink($pathWithImage);
                        $_SESSION['photo_error']="Person not added , please try again !";
                        header("location:../add_people.php");

                    }
                }
            } else {
                $_SESSION['photo_error'] = "Only .jpeg , .jpg , .png files are accepted";
                header("location:../add_people.php");
            }
        } else {
            $_SESSION['photo_error'] = "Photo size must be in " . 3 . " MB.";
            header("location:../add_people.php");
        }
    } else {
        $_SESSION['photo_error'] = "Error in photo uploading.";
        header("location:../add_people.php");
    }

    include("../../../common/connection/connection.php");

}