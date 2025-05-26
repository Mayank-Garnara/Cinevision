<?php
session_start();

if (isset($_POST['btnLogIn']) && $_POST['btnLogIn'] == "btnLogIn") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email)) {
        if (!empty($password)) {

            include("../../common/connection/connection.php");

            $query = "SELECT * FROM user WHERE email = :email LIMIT 1";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() == 0) {
                $_SESSION['logInError'] = "Invalid User and Password";
                header("Location: ../log-in.php");
                exit;
            }

            if ($user['password'] == md5($password)) {
                $_SESSION['user'] = $user;

                if (isset($_SESSION['logInRedirect'])) {
                    $id = md5($_SESSION['logInRedirect']['id']);
                    $type = $_SESSION['logInRedirect']['type'];

                    if ($type == 'movie') {
                        header("Location: ../player/movie_player.php?id=" . $id);
                    } else if ($type == 'trailer') {
                        header("Location: ../player/trailer_player.php?id=" . $id);
                    } else if ($type == 'teaser') {
                        header("Location: ../player/teaser_player.php?id=" . $id);
                    }
                    // exit;
                    header("Location: ../index.php");
                    // echo "hetre";
                } else {

                    header("Location: ../index.php");
                    exit;
                }
            } else {
                $_SESSION['logInError'] = "Invalid Username and Password";
                header("Location: ../log-in.php");
                exit;
            }

        } else {
            $_SESSION['logInError'] = "Enter Password";
            header("Location: ../log-in.php");
            exit;
        }
    } else {
        $_SESSION['logInError'] = "Enter Email";
        header("Location: ../log-in.php");
        exit;
    }
} else {
    $_SESSION['logInError'] = "Invalid Request";
    header("Location: ../log-in.php");
    exit;
}
?>
