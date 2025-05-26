<?php
session_start();
include "../../common/function.php";


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {


    $movieID = $_SESSION['movieId']; // Get movie ID from POST request
    $imageType = $_POST['image_type']; // Default to "poster" if not set
    $updateQuery = "";

    if (!$movieID) {
        echo "MOVIE ID NOT FOUND";
        exit;
    }

    $uploadDir = "../../../uploads/movies/" . $movieID . "/";

    // Create the folder if it doesn't exist
    if (!is_dir($uploadDir)) {
        createMovieDirectory($movieID);
    }

    // Allowed columns to prevent SQL injection
    $allowedColumns = ['poster', 'banner', 'thumbnail', 'certificate'];
    if (!in_array($imageType, $allowedColumns)) {
        echo "INVALID IMAGE TYPE";
        exit;
    }

    include("../../../common/connection/connection.php");

    // Safe query with validated column name
    $query = "SELECT $imageType FROM movie WHERE id = :movieID";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':movieID' => $movieID]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);


    if ($stmt->rowCount() == 0) {
        echo "MOVIE ID NOT FOUND";
        exit;
    } else if ($result[$imageType] != null) {
        $fileName = $result[$imageType];
    } else {
        // Generate a unique file name (imageType_timestamp.jpg)
        $fileName = $imageType . "_" . time() . ".jpg";
    }


    $targetFile = $uploadDir . 'photos/' . $fileName;

    // Allowed file types
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($_FILES["image"]["type"], $allowedTypes)) {
        echo "INVALID FILE FORMAT";
        exit;
    }

    // Move the uploaded image
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {

        // Insert image path into the database
        try {

            // Safe UPDATE query with validated column name
            $updateQuery = "UPDATE movie SET $imageType = :path WHERE id = :movieID";
            $stmt = $pdo->prepare($updateQuery);
            $stmt->execute([
                ':movieID' => $movieID,
                ':path' => $fileName
            ]);
            $_SESSION['success'];
            echo "SUCCESS";
            exit;
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    } else {
        echo "IMAGE UPLOAD ERROR";
        exit;
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    include("../../../common/connection/connection.php");

    $movieID = $_POST['movieId'];
    $query = "SELECT poster, banner, thumbnail ,certificate FROM movie WHERE id = :movieID";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':movieID' => $_POST['movieId']]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() == 0) {
        $_SESSION['serverError']="Movie not found";
        header('location:../../dashboard_module/pending_movie.php');
        exit;
    } else if ($result['poster'] != null && $result['banner'] != null && $result['thumbnail'] != null && $result['certificate'] != null) {
        include('../../common/updateStep.php');
        updateStep($movieID, 'step4', $pdo);
        $_SESSION['success']="All images are uploaded";
        header("location:../../dashboard_module/step5.php?movieId=" . $movieID);
    } else {
        $_SESSION['serverError'] = "Please upload all required photos first !";
        header("location:../../dashboard_module/step4.php?movieId=" . $movieID);
    }
} else {
    echo "INVALID REQUEST";
}
?>