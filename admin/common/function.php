<?php
function getMovieProgressStep($movieId, $wichStep)
{
    // Correct JSON format
    include("../../common/connection/connection.php");
    $selectStatusQuery = "SELECT upload_step FROM movie WHERE id=?";
    $selectStatusStmt = $pdo->prepare($selectStatusQuery);

    $selectStatusStmt->execute([
        $movieId
    ]);

    $selectStatusData = $selectStatusStmt->fetch(PDO::FETCH_ASSOC);
    $jsonStr = $selectStatusData['upload_step'];

    $data = json_decode($jsonStr, true); // Decode as associative array
    ?>
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary rounded-top p-4">
            <ul class="nav nav-pills" style="width:100%; border-bottom:5px solid red">
                <li class="nav-item">
                    <a href="step1.php?movieId=<?= $movieId ?>">
                        <div class="nav-link  <?php echo $wichStep == 1 ? "active active-style text-white" : "text-body" ?> ">
                            Besic Detail
                            (<?php echo $data['step1'] == 1 ? "<span class='status text-success'>Done</span>" : "<span class='status " . ($wichStep == 1 ? "text-white" : "text-primary") . "'>Pending</span>" ?>)
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="step2.php?movieId=<?= $movieId ?>">
                        <div class="nav-link <?php echo $wichStep == 2 ? "active active-style text-white" : "text-body" ?> ">
                            Movie Details
                            (<?php echo $data['step2'] == 1 ? "<span class='status text-success'>Done</span>" : "<span class='status  " . ($wichStep == 2 ? "text-white" : "text-primary") . "'>Pending</span>" ?>)
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="step3.php?movieId=<?= $movieId ?>">
                        <div class="nav-link <?php echo $wichStep == 3 ? "active active-style text-white" : "text-body" ?> ">
                            Add Cast
                            (<?php echo $data['step3'] == 1 ? "<span class='status text-success'>Done</span>" : "<span class='status  " . ($wichStep == 3 ? "text-white" : "text-primary") . "'>Pending</span>" ?>)
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="step4.php?movieId=<?= $movieId ?>">
                        <div class="nav-link <?php echo $wichStep == 4 ? "active active-style text-white" : "text-body" ?> ">
                            Photo upload
                            (<?php echo $data['step4'] == 1 ? "<span class='status text-success'>Done</span>" : "<span class='status  " . ($wichStep == 4 ? "text-white" : "text-primary") . "'>Pending</span>" ?>)
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="step5.php?movieId=<?= $movieId ?>">
                        <div class="nav-link <?php echo $wichStep == 5 ? "active active-style text-white" : "text-body" ?> ">
                            Movie upload
                            (<?php echo $data['step5'] == 1 ? "<span class='status text-success'>Done</span>" : "<span class='status  " . ($wichStep == 5 ? "text-white" : "text-primary") . "''>Pending</span>" ?>)
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="step6.php?movieId=<?= $movieId ?>">
                        <div class="nav-link <?php echo $wichStep == 6 ? "active active-style text-white" : "text-body" ?> ">
                            Final upload
                            (<?php echo $data['step6'] == 1 ? "<span class='status text-success'>Done</span>" : "<span class='status  " . ($wichStep == 6 ? "text-white" : "text-primary") . "''>Pending</span>" ?>)
                        </div>
                    </a>
                </li>
                
            </ul>
        </div>
    </div>

    <?php

}
function createMovieDirectory($name)
{

    $uploadDir = "../../../uploads/movies/" . $name . "/";
    mkdir($uploadDir, 0777, true);
    mkdir($uploadDir . "photos", 0777, true);
    mkdir($uploadDir . "video", 0777, true);
    mkdir($uploadDir . "video/trailer", 0777, true);
    mkdir($uploadDir . "video/teaser", 0777, true);
    mkdir($uploadDir . "video/movie", 0777, true);

}
?>