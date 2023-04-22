<?php

$dbHost = "localhost";
$dbName = "u_220087405_db";
$username = "u-220087405";
$password = "bgGOxub24jFgxhK";

try {
    $db = new PDO("mysql:dbname=$dbName;host=$dbHost", $username, $password);
} catch (PDOException $e) {
    echo ("Failed to connect to the database.<br>");
    echo ($e->getMessage());
    exit;

}
