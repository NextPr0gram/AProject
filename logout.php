<?php
session_start();
unset($_SESSION["username"]);
session_destroy();
header("Location: index.php");
?>

<h2>Logged out now!</h2>
<p>Would you like to login again?<a href="index.php">Login</a></p>
