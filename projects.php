<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Document</title>
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
                        <?php
						if (isset($_SESSION['username'])) {
                        ?>
                            <a class="nav-link" href="user.php">Your Projects</a>
                        <?php
                        }?>
   
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                    <?php
                        session_start();
                        if (!isset($_SESSION['username'])) {
                        ?>
                            <li class='nav-item'>
                                <a class='nav-link' href='index.php'>
                                    <button class='btn btn-primary' type='button'>Login</button>
                                </a>
                            </li>
                            <li class='nav-item'>
                                <a class='nav-link' href='register.php'>
                                    <button class='btn btn-primary' type='button'>Register</button>
                                </a>
                            </li>
                        <?php
                        } else {
                        ?>
                            <li class='nav-item'>
                                <a class='nav-link' href='logout.php'>
                                    <button class='btn btn-primary' type='button'>Logout</button>
                                </a>
                            </li>
                        <?php
                        }
                        ?>

                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container">
    <form class="form-inline" action="projects.php" method="post">
        <div class="d-flex">
            <div class="form-group mx-sm-3 mb-2">
            <input type="text" name="search" class="form-control" placeholder="Search Title or Date (yyyy-mm-dd)">
            </div>
            <input type="submit" name="submit" class="btn btn-primary mb-2" value="Search">
            <input type="hidden" name="submitted" value="true">
        </div>
        </form>


            <dialog id="myDialog">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Project Information</h3>
                </div>
                <div class="modal-body">
                    <p>Title: <span id="projectTitle"></span></p>
                    <p>Start Date: <span id="startDate"></span></p>
                    <p>End Date: <span id="endDate"></span></p>
                    <p>Phase: <span id="phase"></span></p>
                    <p>Description: <span id="description"></span></p>
                    <p>Project ID: <span id="pid"></span></p>
                    <hr>
                    <h3>User Information</h3>
                    <p>Username: <span id="username"></span></p>
                    <p>Email Address: <span id="email"></span></p>
                    <p>User ID: <span id="uid"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="closeDialog()">Close</button>
                </div>
                </div>
            </div>
            </dialog>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <footer class="bg-light text-center text-lg-start fixed-bottom">
        <div class="text-center " style="background-color: rgba(0, 0, 0, 0.2);">
            <p class="text-dark m-0">Anaf Ibn Karim | 220087405@aston.ac.uk</p>
        </div>
    </footer>
</body>
<script>

    function openDialog(title, startDate, endDate, phase, description, pid, uid) {
    var myDialog = document.getElementById("myDialog");
    myDialog.showModal();
    document.getElementById("projectTitle").innerHTML = title;
    document.getElementById("startDate").innerHTML = startDate;
    document.getElementById("endDate").innerHTML = endDate;
    document.getElementById("phase").innerHTML = phase;
    document.getElementById("description").innerHTML = description;
    document.getElementById("pid").innerHTML = pid;

    //Make a GET request to projects.php with the pid parameter.
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get-user-information.php?uid=' + uid);
    xhr.onload = function() {
      if (xhr.status === 200) {
        var data = JSON.parse(xhr.responseText);
        document.getElementById("username").innerHTML = data.username;
        document.getElementById("email").innerHTML = data.email;
        document.getElementById("uid").innerHTML = data.uid;
      } else {
        console.error('Error: ' + xhr.status);
      }
    };
    xhr.send();
  }


    function closeDialog() {
        var myDialog = document.getElementById("myDialog");
        myDialog.close();
    }
</script>
</html>

<?php

require_once "connectdb.php";
echo ("<h2 class='text-center mb-4'>All projects</h2>");
$searchQuery = "";
if (isset($_POST["submitted"])) {
    $search = $_POST["search"];
    $searchQuery = "
        SELECT * FROM projects
        WHERE title LIKE '%$search%'
        OR start_date LIKE '%$search%'
    ";
}

try {
    $query = "select * from projects ";
    if ($searchQuery != "") {
        $query = $searchQuery;
    }
    //run the query
    $rows = $db->query($query);

    //Display the course list in a table

    if ($rows && $rows->rowCount() > 0) {?>
		<div class="row justify-content-center">
    		<div class="col-auto">
        		<table cellspacing="0" cellpadding="5" id="myTable" class="table table-responsive">
            		<tr>
                		<th><b>Title</b></th>
               			 <th><b>Start Date</b></th>
               			 <th><b>Description</b></th>
              			 <th><b></b></th>
           		 	</tr>
            </div>
    	</div>
            <?php
//Fetch and print all the records.
        while ($row = $rows->fetch()) {
            echo ("<tr><td>" . $row['title'] . "</td>");
            echo ("<td>" . $row['start_date'] . "</td>");
            echo ("<td>" . $row['description'] . "</td>");
            echo ("<td>" . $row['delete'] . "<button class='btn btn-primary' onclick='openDialog(
                \"" . $row['title'] . "\",
                \"" . $row['start_date'] . "\",
                \"" . $row['end_date'] . "\",
                \"" . $row['phase'] . "\",
                \"" . $row['description'] . "\",
                \"" . $row['pid'] . "\",
                \"" . $row['uid'] . "\"
                )'>Details</button></td></tr>");
        }
        echo ("</table>");

    } else {
        echo ("<p class='text-center'>No Projects in the list.</p>"); //No match found
    }

} catch (PDOException $e) {
    echo ("Sorry, a database error occurred! <br>");
    echo ("Error details: <em>" . $e->getMessage() . "</em>");
}

?>