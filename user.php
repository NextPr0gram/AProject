<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Your Projects</title>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="projects.php"><b> AProject</b></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="projects.php">View Projects</a>
                        </li>
						<li class="nav-item">
                            <a class="nav-link" href="user.php">Your Projects</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="add-project.php">
                                <button class="btn btn-primary" type="button">Add New Project</button>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">
                                <button class="btn btn-primary" type="button">Logout</button>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
        <dialog id="myDialog">
            <form class="form-horizontal" action="delete-project.php" method="post">
                <h3>Are you sure you want to delete this project?</h3>
                <p id="projectName">Project name: </p>
                <button class="btn btn-primary" type="button" onclick="closeDialog()">Close</button>
                <input type="submit"  class="btn btn-danger"name="delete" value="delete">
                <input type="hidden" id="projectId" name="projectId">
            </form> 
        </dialog>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    

<?php

session_start();
//Step 1: Check if the user is not logged in, redirect to start
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION["username"];
echo "<h1 class='text-center mb-4'>Welcome $username!</h1>";

//Step 2: Include the connectdb.php to connect to the database.
require_once "connectdb.php";

echo ("<h2 class='text-center mb-4'>Your projects</h2>");
try {
    $id = $_SESSION["uid"];
    $query = "select * from projects where uid = $id";

    //run the query
    $rows = $db->query($query);

    if ($rows && $rows->rowCount() > 0) {?>
		<div class="row justify-content-center">
    		<div class="col-auto">
        		<table cellspacing="0" cellpadding="5" id="myTable" class="table table-responsive">
            		<tr>
                	<th><b>Title</b></th>
                	<th><b>Start Date</b></th>
                	<th><b>End date</b></th>
                	<th><b>Phase</b></th>
                	<th><b>Description</b></th>
                	<th><b></b></th>
                	<th><b></b></th>

            </tr>
            <?php
//Fetch and print all the records.
        while ($row = $rows->fetch()) {
            echo ("<tr><td>" . $row['title'] . "</td>");
            echo ("<td>" . $row['start_date'] . "</td>");
            echo ("<td>" . $row['end_date'] . "</td>");
            echo ("<td>" . $row['phase'] . "</td>");
            echo ("<td>" . $row['description'] . "</td>");
            echo ("<td><a href='edit-project.php?pid=" . $row['pid'] . "'><button class='btn btn-primary' type='button'>Edit</button></a></td>");
            $title = $row['title'];
            echo ("<td>" . $row['delete'] . "<button class='btn btn-danger' onclick='return openDialog(\"" . $row['title'] . "\", " . $row['pid'] . ")'>Delete</button></td></tr>");

        }
        echo ("</table> </div> </div>");

    } else {
        echo ("<p class='text-center'>No Projects in the list.</p>"); //No match found
    }

} catch (PDOException $e) {
    echo ("Sorry, a database error occurred! <br>");
    echo ("Error details: <em>" . $e->getMessage() . "</em>");
}

?>
    <footer class="bg-light text-center text-lg-start fixed-bottom">
        <div class="text-center " style="background-color: rgba(0, 0, 0, 0.2);">
            <p class="text-dark m-0">Anaf Ibn Karim | 220087405@aston.ac.uk</p>
        </div>
    </footer>
</body>
<script>
    var projectName = document.getElementById("projectName")
    var projectId = document.getElementById("projectId")
    function openDialog(title, pid) {
        var myDialog = document.getElementById("myDialog");
        myDialog.showModal();
        projectName.innerHTML = "Project name: " + title;
        projectId.value = pid;
    }   

    function closeDialog() {
        var myDialog = document.getElementById("myDialog");
        myDialog.close();
    }
</script>
</html>
