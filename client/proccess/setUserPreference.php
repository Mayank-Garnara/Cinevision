<?php
header("Content-Type: application/json");

if(isset($_POST['preference']))
{
    try {
        // Create PDO connection
        include("../../common/connection/connection.php");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        // Get POST data
        $user_id = $_POST['user_id'] ?? null;
        $preference = $_POST['preference'] ?? null;
    
        if (!$user_id || !$preference) {
            echo "Missing user_id or preference";
            exit();
        }
    
        // Update query
        $stmt = $pdo->prepare("UPDATE user SET preference = :preference WHERE id = :user_id");
        
        $stmt->execute([
            ':preference' => $preference,
            ':user_id' => $user_id
        ]);
    
        echo "Preference updated successfully.";
    
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
}

?>
