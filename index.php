<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>AProject</title>
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
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">
                                <button class="btn btn-primary" type="button">Register</button>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mb-4">Welcome to AProject</h1>
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Login</h2>
                        <form class="form-horizontal" action="index.php"  method="post">
                            <div class="form-group">
                                <label class="control-label" for="username">Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-group d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary ">Login</button>
                            </div>
                            <div col-md-12 text-center>

                            </div>
                            <input type="hidden" name="submitted" value="true">
                            <p class="text-center">Not a registered user? <a href="./register.php">Register</a></p>
<?php

//Checks if the form has been submitted.
if (isset($_POST["submitted"])) {

    //Checks if both username and password fields are filled.
    if (empty($_POST["username"]) || empty($_POST["password"])) {
        exit("<p>Please fill both the username and password fields!</p>");
    }

    //Connects to the database.
    require_once "connectdb.php";

    try {
        //Queries DB to find the matching username/password.
        //Prepares the SQL statement with a placeholder for the username and then executes it.
        $stat = $db->prepare("select password from users where username = ?");
        $stat->execute(array($_POST["username"]));

        if ($stat->rowCount() > 0) { // matching username
            $row = $stat->fetch();

            if (password_verify($_POST["password"], $row["password"])) {
                session_start();
                $_SESSION["username"] = $_POST["username"];

                $username = $_POST["username"];
                $password = $row["password"];
                $uid_query = $db->prepare("SELECT UID FROM users WHERE username = ? AND password = ?");
                $uid_query->execute(array($username, $password));

                // Check if the query was successful and if a matching user was found
                if ($uid_query && $uid_query->rowCount() > 0) {
                    $row = $uid_query->fetch();
                    $_SESSION["uid"] = $row["UID"];
                }

                header("Location:user.php");
                exit();
            } else {
                echo "<p class='text-center'>Error logging in, password does not match</p>";
            }
        } else {
            echo "<p class='text-center'>Error logging in, username not found</p>";

        }

    } catch (PDOException $e) {
        echo ("Failed to connect to the database");
        echo $e->getMessage();
        exit;
    }
}

?>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <footer class="bg-light text-center text-lg-start fixed-bottom">
        <div class="text-center " style="background-color: rgba(0, 0, 0, 0.2);">
            <p class="text-dark m-0">Anaf Ibn Karim | 220087405@aston.ac.uk</p>
        </div>
    </footer>
</body>
</html>