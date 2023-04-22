<?php
session_start();
//Check if the user is not logged in, redirect to index.php.
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

require_once "connectdb.php";

if (isset($_POST['projectId'])) {
    $pid = $_POST['projectId'];

    try {
        $query = "DELETE FROM projects WHERE pid = $pid";
        $stmt = $db->prepare($query);
        $stmt->execute();
        header("Location: user.php");
        exit();
    } catch (PDOException $e) {
        echo ("Sorry, a database error occurred! <br>");
        echo ("Error details:" . $e->getMessage() . "</em>");
        exit();
    }
} else {
    header("Location: user.php");
    exit();
}
