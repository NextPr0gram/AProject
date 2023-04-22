<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Edit project</title>
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
        <form class="form-horizontal" action="edit-project.php" method="post">
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
            <input type="hidden" name="pid" value="<?php echo($_GET['pid']) ?>">
            

        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <footer class="bg-light text-center text-lg-start fixed-bottom">
        <div class="text-center " style="background-color: rgba(0, 0, 0, 0.2);">
            <p class="text-dark m-0">Anaf Ibn Karim | 220087405@aston.ac.uk</p>
        </div>
    </footer>
</body>
</html>

<?php

session_start();
//echo("<input type='hidden' name='pid' value='$pid'>");   
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];

    //Connect to the database.
    require_once "connectdb.php";

    //Select the project with the given pid.
    $stat = $db->prepare("SELECT * FROM projects WHERE pid = ?");
    $stat->execute(array($pid));
    $rows = $stat->fetchAll(PDO::FETCH_ASSOC);

    if ($rows && count($rows) > 0) {
        $row = $rows[0]; //Gets the first row.

        //Puts all the items in the $fields associative array.
        $fields = array(
            "title" => $row['title'],
            "start-date" => $row['start_date'],
            "end-date" => $row['end_date'],
            "phase" => $row['phase'],
            "description" => $row['description'],
        );
        //Prefills the form with the already existing information.
        foreach ($fields as $key => $value) {
            ?><script>
                field = document.getElementById( "<?php echo ($key) ?>" )
                field.value = "<?php echo ($value) ?>"
            </script><?php
        }
            
    }   
}

//Checks if form is submitted.
if (isset($_POST["submitted"])) {
    require_once "connectdb.php";

    //Variables relating to the fields in the form.
    $title = isset($_POST["title"]) ? $_POST["title"] : false;
    $startDate = isset($_POST["start-date"]) ? $_POST["start-date"] : false;
    $endDate = isset($_POST["end-date"]) ? $_POST["end-date"] : false;
    $phase = isset($_POST["phases"]) ? $_POST["phases"] : false;
    $description = isset($_POST["description"]) ? $_POST["description"] : false;
    $description = clean($description);
    $pid = $_POST["pid"];

    function clean($string) {     
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }
    //Array of the fields from the form
    $fields = array("title" => $title, "start-date" => $startDate, "end-date" => $endDate, "phase" => $phase, "description" => $description, "pid" => $pid);
     
    //Checks if all the fields are populated, if not then it echos a message and the javascript code makes sure
    //that the fields that were populate remain there.
    //Then an external script is run to highligh in red the unpopulated fields.
    if (in_array("", $fields, true)) {

        echo ("Please fill out all required fields.");
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

        echo ("<script src='./javascript/add-project-form-validation.js'></script>");
    } else {
        try {
            //Prepares the query, executes it using the $fields array then finally echos a message confirming the submission.
            $stat = $db->prepare("UPDATE projects SET title = ?, start_date = ?, end_date = ?, phase = ?, description = ? WHERE pid = ?");
            $stat->execute(array_values($fields));
            ?>
                <dialog open>
                    <h3>Congratulations! Your changes have been added succesfully.</h3>
                    <a href='user.php'><button class="btn btn-primary" type='button'>Return</button></a>
                </dialog>

            <?php

        } catch (PDOException $e) {
            echo ("Sorry, a database error occurred! <br>");
            echo ($e->getMessage());
        }
    }

}
?>

