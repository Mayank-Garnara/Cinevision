<?php
session_start();
if (isset($_POST['id'])) {
    //this should come from session
    $movieID = $_SESSION['movieId'];
    include('../../common/connection/connection.php');
    $selectCast = "SELECT * FROM movie_cast WHERE movie_id = ?";
    $stmt = $pdo->prepare($selectCast);

    $stmt->execute([
        $movieID
    ]);

    if($stmt->rowCount() == 1){
        echo "ONE CAST ONLY";
    }
    else if ($stmt->rowCount() > 0) {
        $deletCast = "DELETE FROM movie_cast WHERE movie_id = ? AND id=?";
        $deleteStmt = $pdo->prepare($deletCast);

        if($deleteStmt->execute([$movieID,$_POST['id'] ] ) ) {
            echo "success";
        }else{
            echo "not deleted";
        }
    }
}
?>