<?php
session_start();
$movieID = $_SESSION['movieId'];
if ($movieID) {
    if (isset($_POST['dateToUpload'])) {
        $raw_datetime = $_POST['dateToUpload'] ?? '';

        $datetime = filter_var($raw_datetime, FILTER_SANITIZE_STRING);

        if (preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $datetime)) {
            $dt = DateTime::createFromFormat('Y-m-d\TH:i', $datetime);

            if ($dt) {
                require "../../../common/connection/connection.php";

                $select = "SELECT upload_step FROM movie WHERE id=:id";
                $stmt = $pdo->prepare($select);
                $stmt->bindParam(":id", $movieID);
                $stmt->execute();
                $records = $stmt->fetch(PDO::FETCH_ASSOC);


                $jsonStr = $records['upload_step'];

                $data = json_decode($jsonStr, true);


                foreach ($data as $key => $value) {
                    if ($value == false) {
                        if ($key != "step6") {
                            $_SESSION['error']['timeError'] = "Please update remaining steps ";
                            header("location:../../dashboard_module/step6.php?movieId=$movieID");
                            exit;
                        }
                    }
                }


                $uploadFrom = $dt->format("Y-m-d H:i:s"); // Convert to string
                $qry = "UPDATE movie SET upload_from = :uploadFrom, movie_status=:status WHERE id = :id";
                $stmt = $pdo->prepare($qry);
                $one = 1;
                $stmt->bindParam(":uploadFrom", $uploadFrom);
                $stmt->bindParam(":status", $one);
                $stmt->bindParam(":id", $movieID);

                include('../../common/updateStep.php');
                updateStep($movieID, 'step6', $pdo);

                if ($stmt->execute()) {
                    echo "Data updated";
                    header("location:../../dashboard_module/uploaded_movie.php");
                } else {
                    $_SESSION['error']['timeError'] = "Something went wrong, please try again";
                    header("Location: ../../dashboard_module/step6.php?movieId=$movieID");
                    exit;
                }
            } else {
                $_SESSION['error']['timeError'] = "Enter valid date and time for release movie";
                header("location:../../dashboard_module/step6.php?movieId=$movieID");
                echo "Input does not match expected format.";
            }
        } else {
            $_SESSION['error']['timeError'] = "Enter valid date and time for release movie";
            header("location:../../dashboard_module/step6.php?movieId=$movieID");
            echo "Input does not match expected format.";
        }
    } else if ($_GET['addNow'] == true) {
        require "../../../common/connection/connection.php";
        // echo "i am going to update now";
        $select = "SELECT upload_step FROM movie WHERE id=:id";
        $stmt = $pdo->prepare($select);
        $stmt->bindParam(":id", $movieID);
        $stmt->execute();
        $records = $stmt->fetch(PDO::FETCH_ASSOC);


        $jsonStr = $records['upload_step'];

        $data = json_decode($jsonStr, true);


        foreach ($data as $key => $value) {
            if ($value == false) {
                if ($key != "step6") {
                    $_SESSION['error']['timeError'] = "Please update remaining steps ";
                    header("location:../../dashboard_module/step6.php?movieId=$movieID");
                    exit;
                }
            }
        }

        $dt = new DateTime();
        $uploadFrom = $dt->format("Y-m-d H:i:s"); // Convert to string
        $qry = "UPDATE movie SET upload_from = :uploadFrom, movie_status=:status WHERE id = :id";
        $stmt = $pdo->prepare($qry);
        $one = 1;
        $stmt->bindParam(":uploadFrom", $uploadFrom);
        $stmt->bindParam(":status", $one);
        $stmt->bindParam(":id", $movieID);

        include('../../common/updateStep.php');
        updateStep($movieID, 'step6', $pdo);

        if ($stmt->execute()) {
            echo "Data updated";
            header("location:../../dashboard_module/uploaded_movie.php");
        } else {
            $_SESSION['error']['timeError'] = "Something went wrong, please try again";
            header("Location: ../../dashboard_module/step6.php?movieId=$movieID");
            exit;
        }
        //copy the code form above given code and get the current time and set that variable in bindParam
    }
} else {


    header("location:../../dashboard_module/pending_movie.php");

}

?>