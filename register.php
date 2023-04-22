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
                            <a class="nav-link" href="index.php">
                                <button class="btn btn-primary" type="button">Login</button>
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
                        <h2 class="text-center mb-4">Register</h2>
                        <form class="form-horizontal" action="register.php"  method="post">
                            <div class="form-group">
                                <label class="control-label" for="username">Username</label>
                                <input type="text" name="username" class="form-control" id="username" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="username">Email</label>
                                <input type="email" name="email" class="form-control" id="email" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password">Password</label>
                                <input type="password" name="password" class="form-control id="password"" required>
                            </div>
                            <div class="form-group d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary ">Register</button>
                            </div>
                            <div col-md-12 text-center>

                            </div>
                            <input type="hidden" name="submitted" value="true">
                            <p class="text-center">Already a registered user? <a href="./index.html">Login</a></p>
                            <?php


if (isset($_POST["submitted"])) {

    //Prepares the form input.
    //Connects ot the database.
    require_once "connectdb.php";
    $username = isset($_POST["username"]) ? $_POST["username"] : false;
    $password = isset($_POST["password"]) ? password_hash($_POST["password"], PASSWORD_DEFAULT) : null;
    $email = isset($_POST["email"]) ? $_POST["email"] : false;

    if (!$username) {
        echo ("Please fill the username field");
        exit();
    }

    if (!$password) {
        echo ("Please fill the password field");
        exit();
    }

    if (!$email) {
        echo ("Please fill the email field");
        exit();
    }

    try {
        $stat = $db->prepare("select * from users where username = ? and email = ?");
        $stat->execute(array($username, $email));
        $rows = $stat->fetchAll(PDO::FETCH_ASSOC);

        if ($rows && count($rows) > 0) {
            echo ("<p class='text-center'>An account with the same credentials exists. </p>");
        } else {
            $stat = $db->prepare("insert into users values(default, ?, ?, ?)");
            $stat->execute(array($username, $password, $email));
            $id = $db->lastInsertId();
            echo ("<p class='text-center'>Congratulations! You are now registered, your ID is: $id </p>");
        }

        
    } catch (PDOException $e) {
        echo ("Sorry, a database error occurred! <br>");
        echo ($e->getMessage());
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

