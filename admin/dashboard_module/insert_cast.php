<?php
session_start();
$movieId = $_SESSION['movieId'];

if (isset($_POST['role_id']) && isset($_POST['person_id']) && $_POST['person_id'] != '') {
    include('../../common/connection/connection.php');
    $insertCastQuery = "INSERT INTO movie_cast (`movie_id`,`person_id`,`role_id`) VALUES (?, ?, ?) ";

    $stmt = $pdo->prepare($insertCastQuery);

    $stmt->execute([
        $movieId,
        $_POST['person_id'],
        $_POST['role_id']
    ]);
    if ($stmt->rowCount() == 1) {
        include("../common/updateStep.php");
        updateStep($_SESSION['movieId'], "step3",$pdo);
        $_SESSION['success'] = "Cast added successfully";
        header("location:step3.php?movieId=" . $movieId);
    } else {
        $_SESSION['serverError'] = "Failed to add Cast";
        header("location:step3.php?movieId=" . $movieId);
    }
} else {
    $_SESSION['serverError'] = "Failed to add Cast";
    header("location:step3.php?movieId=" . $movieId);
}
?>