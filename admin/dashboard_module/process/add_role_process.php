<?php
session_start();

if (isset($_POST['name']) && strlen(trim($_POST['name'])) >= 2) {

    // echo "Image moved";
    include('../../../common/connection/connection.php');
    $selectQuery = "SELECT id FROM role WHERE name=:name";
    $selectStmt = $pdo->prepare($selectQuery);
    $selectStmt->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
    $selectStmt->execute();
    if ($selectStmt->rowCount() > 0) {
        $_SESSION['serverError'] = "The " . $_POST['name'] . " role is already added !";
        header("location:../add_role.php");
        exit;
    } else {
        $insertQuery = "INSERT INTO role (name) VALUES (:name)";
        $insertStmt = $pdo->prepare($insertQuery);

        $insertStmt->bindParam(":name", $_POST['name'], PDO::PARAM_STR);

        if ($insertStmt->execute()) {
            $_SESSION['success'] = "Role added successfully !";
            header("location:../add_role.php");
        } else {
            $_SESSION['serverError'] = "Role not added , please try again !";
            header("location:../add_role.php");

        }
    }

}else{
    $_SESSION['serverError']="Please enter valid name of role";
    $_SESSION['form_data']=$_POST;
    header("location:../add_role.php");
}