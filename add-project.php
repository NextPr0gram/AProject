<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Add new project</title>
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
    <div class="container">
        <form class="form-horizontal" action="add-project.php" method="post">
            <div class="form-group">
                <label class="control-label" for="title">Title </label>
                <input class="form-control" type="text" name="title" id="title"><br>
            </div>
            <div class="form-group">
                <label class="control-label" for="start-date">Start date </label>
                <input class="form-control" type="date" name="start-date" id="start-date"><br>
            </div>

            <div class="form-group">
                <label class="control-label" for="title">End date </label>
                <input class="form-control" type="date" name="end-date" id="end-date"><br>
            </div>
            
            <div class="form-group">
                <label class="control-label" for="phases">Phase </label>
                <select class="form-control" name="phases" id="phases">
                    <option>Design</option>
                    <option>Development</option>
                    <option>Testing</option>
                    <option>Deployment</option>
                    <option>Complete</option>
                </select><br>
            </div>

            <div class="form-group">
                <label class="control-label" for="description">Description</label>
                <textarea class="form-control"  maxlength="500" name="description" cols="30" rows="10" id="description"></textarea><br>
            </div>

            <div class="button-group text-center">
                <a href="user.php"><button class="btn btn-primary" type="button">Cancel</button></a>
                <input type="submit"  class="btn btn-primary"name="submit" value="Submit changes"> 
            </div>

            <input type="hidden" name="submitted" value="true">

        </form>
    </div>
    <footer class="bg-light text-center text-lg-start fixed-bottom">
        <div class="text-center " style="background-color: rgba(0, 0, 0, 0.2);">
            <p class="text-dark m-0">Anaf Ibn Karim | 220087405@aston.ac.uk</p>
        </div>
    </footer>
</body>
</html>

<?php

//Checks if form is submitted
if (isset($_POST["submitted"])) {
    
    //connects ot the database
    require_once "connectdb.php";

    //Variables relating to the fields in the form
    $title = isset($_POST["title"]) ? $_POST["title"] : false;
    $startDate = isset($_POST["start-date"]) ? $_POST["start-date"] : false;
    $endDate = isset($_POST["end-date"]) ? $_POST["end-date"] : false;
    $phase = isset($_POST["phases"]) ? $_POST["phases"] : false;
    $description = isset($_POST["description"]) ? $_POST["description"] : false;
    $description = clean($description);
    $uid = $_SESSION["uid"];
    
    function clean($string) {     
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }
    //Array of the fields from the form
    $fields = array("title" => $title, "start-date" => $startDate, "end-date" => $endDate, "phase" => $phase, "description" => $description, "uid" => $uid);

    //Checks if all the fields are populated, if not then it echos a message and the javascript code makes sure
    //that the fields that were populate remain there.
    //Then an external script is run to highligh in red the unpopulated fields.
    if (in_array("", $fields, true)) {

        echo ("<p class='text-center'>Please fill out all required fields.</p>");
        foreach ($fields as $key => $value) {
            ?><script>
                field = document.getElementById( "<?php echo ($key) ?>" )
                field.value = "<?php echo ($value) ?>"
            	fields = [
    				title = document.getElementById("title"),
    				startDate = document.getElementById("start-date"),
    				endDate = document.getElementById("end-date"),
    				phase = document.getElementById("phases"),
    				description = document.getElementById("description"),
					];

				fields.forEach(function(field) {
    				if (field.value.length == 0) {
        				field.style.borderColor = "red";
    				} else {
        				field.style.borderColor = "";
    				}
				});
            </script><?php
}

     
    } else {
        try {
            //Checks if a project with the same name and the same user already exists.

            $stat = $db->prepare("SELECT * FROM projects WHERE title = ? AND uid = ?");
            $stat->execute(array($title, $uid));
            $rows = $stat->fetchAll(PDO::FETCH_ASSOC);

            //If it finds a project with the same name and the same user it echos a message.
            if ($rows) {
                echo ("A project with this name already exists");
            } else {
                //Prepares the query, executes it using the $fields array then finally echos a message confirming the submission.
                $stat = $db->prepare("insert into projects values(default, ?, ?, ?, ?, ?, ?)");
                $stat->execute(array_values($fields));
                $id = $db->lastInsertId();
                ?>
                <dialog open id="myDialog">
                    <h3>Congratulations! Your project has been added successfully.</h3>
                    <a href='user.php'><button class="btn btn-primary" type='button'>Return</button></a>
                </dialog>
                <?php
            }
        } catch (PDOException $e) {
            echo($uid);
            echo ("Sorry, a database error occurred! <br>");
            echo ($e->getMessage());
        }
    }

}
?>
