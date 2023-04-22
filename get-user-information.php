<?php
require_once "connectdb.php";
if (isset($_GET['uid'])) {
    $uid = $_GET['uid'];
    try {
        // Prepare the query to retrieve the user information
        $stat = $db->prepare("SELECT username, email, uid FROM users WHERE uid = :uid");
        $stat->bindParam(':uid', $uid, PDO::PARAM_INT);
        $stat->execute();

    
        // Retrieve the user information and return it in JSON format
        $userRow = $stat->fetch(PDO::FETCH_ASSOC);
        header('Content-Type: application/json');
        echo(json_encode($userRow));
        exit();
    } catch (PDOException $e) {
        // Handle any database errors here
        echo("Database Error: " . $e->getMessage());
    }
}
?>