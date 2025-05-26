<?php
session_start();
if (isset($_POST['videoType']) && isset($_FILES['movieFile']) && isset($_SESSION['movieId'])) {
    $movieId;
    $allowedColumns = ['teaser', 'trailer', 'movie'];
    if (!in_array($_POST['videoType'], $allowedColumns)) {
        echo "INVALID VIDEO TYPE";
        exit;
    }

    $targetDir = "../../../uploads/movies/" . $_SESSION['movieId'] . "/video/" . $_POST['videoType'] . "/";


    $uploadedFile = $targetDir . "temp" . "." . pathinfo($_FILES['movieFile']['name'], PATHINFO_EXTENSION);

    $isValidExtension = $_FILES['movieFile']['type'] == "video/mkv" ||
        $_FILES['movieFile']['type'] == "video/x-matroska" ||
        $_FILES['movieFile']['type'] == "video/mp4" ||
        $_FILES['movieFile']['type'] == "video/webm";

    $isVideoAlreadyUploaded = false;
    include('../../../common/connection/connection.php');
    $isVideoInDbQuery = "SELECT " . $_POST['videoType'] . " FROM movie WHERE id=:id";
    $isVideoInDbStmt = $pdo->prepare($isVideoInDbQuery);
    $isVideoInDbStmt->bindParam(":id", $_SESSION['movieId']);
    $isVideoInDbStmt->execute();
    $isVideoInDbResult = $isVideoInDbStmt->fetch(PDO::FETCH_ASSOC);

    //if the video is already in directory then condition will true and delete all old files
    if ($isVideoInDbResult[$_POST['videoType']] != null) {
        //for remove extra script from any malicious user
        $GLOBALS['movieId'] = preg_replace('/[^0-9a-zA-Z_-]/', '', $_SESSION['movieId']);
        $videoType = preg_replace('/[^0-9a-zA-Z_-]/', '', $_POST['videoType']);

        $path = "../../../uploads/movies/$movieId/video/$videoType/";
        //for get all the files in files array
        $files = glob($path . "*.*");

        //deleting every files using unlink function - unlink only accepts one file...
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
    //unset($isVideoInDbResult);//needs to be check again=============================

    if ($isValidExtension) {
        // echo "Valid extrension";
        if (move_uploaded_file($_FILES["movieFile"]["tmp_name"], $uploadedFile)) {
            echo $uploadedFile;


            // Convert video using FFmpeg for HLS
            $targetDir .= $_SESSION['movieId'] . ".mpd";
            if ($_POST['videoType'] == "movie") {
                // echo "movie is cutting";
                shell_exec("ffmpeg -i $uploadedFile -codec: copy -start_number 0 -hls_time 10 -hls_list_size 0 -f dash $targetDir");
            } else {
                $command = 'ffmpeg -y -i "' . $uploadedFile . '" ' .
                '-filter_complex "[0:v]split=3[v360][v720][v1080];' .
                '[v360]scale=w=640:h=360:force_original_aspect_ratio=decrease:force_divisible_by=2[v360out];' .  // Added force_divisible_by
                '[v720]scale=w=1280:h=720:force_original_aspect_ratio=decrease:force_divisible_by=2[v720out];' . // Added force_divisible_by
                '[v1080]scale=w=1920:h=1080:force_original_aspect_ratio=decrease:force_divisible_by=2[v1080out]" ' . // Added force_divisible_by
                '-map [v360out] -map [v720out] -map [v1080out] ' .
                '-map 0:a ' .
                '-c:v libx264 -preset medium -profile:v high -level 4.1 ' .
                '-c:a aac -b:a 128k -ac 2 ' .
                '-b:v:0 1000k -maxrate:v:0 1500k -bufsize:v:0 2000k ' .
                '-b:v:1 2500k -maxrate:v:1 3500k -bufsize:v:1 5000k ' .
                '-b:v:2 5000k -maxrate:v:2 7500k -bufsize:v:2 10000k ' .
                '-keyint_min 60 -g 60 -sc_threshold 0 ' .
                '-use_timeline 1 -use_template 1 ' .
                '-seg_duration 4 -frag_duration 1 -frag_type duration ' .
                '-adaptation_sets "id=0,streams=0 id=1,streams=1 id=2,streams=2 id=3,streams=3" ' . // Modified adaptation sets
                '-f dash "' . $targetDir . '" 2>&1';

                $output = shell_exec($command);

                print_r(($output));
            }


            unlink($uploadedFile);

            $files = glob($targetDir);
            foreach ($files as $file) {
                if (is_file($file)) {

                    $videoType = $_POST['videoType'];
                    $videoName = $_SESSION['movieId'] . ".mpd";
                    $movieId = $_SESSION['movieId'];
                    $updateQuery = "UPDATE movie SET " . $videoType . "=:movieFile WHERE id=:id";
                    $updateStmt = $pdo->prepare($updateQuery);
                    $updateStmt->bindParam(":movieFile", $videoName, PDO::PARAM_STR);
                    $updateStmt->bindParam(":id", $movieId);

                    $updateStmt->execute();

                    $selectStatus = "SELECT teaser , trailer , movie FROM movie WHERE id = :id";
                    $stmt = $pdo->prepare($selectStatus);
                    $stmt->bindParam(':id', $_SESSION['movieId']);
                    $stmt->execute();

                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($result['teaser'] != null && $result['trailer'] != null && $result['movie'] != null) {
                        include("../../common/updateStep.php");
                        updateStep($GLOBALS['movieId'], 'step5', $pdo);
                    }

                    echo "SUCCEESS";

                } else {
                    echo "FAILED TO UPLOAD MOVIE";
                }
                break;
            }

        } else {
            echo "falied to move file ";
        }
    } else {
        echo "invalid extension file";
    }
}
?>