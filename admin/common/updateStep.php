<?php
function updateStep($movieId,$stepNumber,$pdo){
    $selectingState = "SELECT upload_step FROM movie WHERE id=?";
    $selectingStateStmt = $pdo->prepare($selectingState);

    $selectingStateStmt->execute([
        $movieId
    ]);

    $stateData = $selectingStateStmt->fetch(PDO::FETCH_ASSOC);
    
    $jsonStr =  $stateData['upload_step'];

    $data = json_decode($jsonStr, true); // Decode as associative array

    $data[$stepNumber]=true;

    $updatedData = json_encode($data);

    $updateIntoDBQuery = "UPDATE movie SET upload_step=? WHERE id=?";
    $updateIntoDBStmt = $pdo->prepare($updateIntoDBQuery);

    $updateIntoDBStmt->execute([
        $updatedData,
        $movieId
    ]);
}
?>