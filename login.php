<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('navbar.php');
include('./db/connection.php');
include('vendor/autoload.php');

use Parse\ParseException;
use Parse\ParseQuery;

$validLogin = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST["email"];
    $password = $_POST["password"];

    try {
        // Query Parse for the user based on the provided email
        $query = new ParseQuery("userRegistration");
        $query->equalTo('email', $email);
        $user = $query->first();

        if ($user) {
            // Verify the password against the hashed password stored in Parse
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $user->get('name');
            $_SESSION['phone'] = $user->get('phone');
            $_SESSION['dob'] = $user->get('dob');
            $_SESSION['gender'] = $user->get('gender');
            $_SESSION['password'] = $user->get('passwprd');
            $_SESSION['fileUpload'] = $user->get('fileUpload');
            $_SESSION['objectId'] = $user->getObjectId();

            // Redirect to home page after successful login
            header("Location: home.php");
            exit();
        } else {
            $validLogin = "<div class='alert alert-danger text-center'>User not found!</div>";
        }
    } catch (ParseException $e) {
        $validLogin = "<div class='alert alert-danger text-center'>" . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">

    <style>
        .form-control {
            border: none;
            border-bottom: 1px solid #0dcaf0;
        }

        .form-control:focus {
            box-shadow: none;
            border-bottom: 1px solid #0dcaf0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <h2 class="mt-5 mb-5 text-center">Login</h2>
            <div class="col-lg-5">
                <form class="login_form" action="" method="POST">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group mt-4">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="text-center mt-4">
                        <p>Dont have an account?
                            <a href="signUp.php" class="text-decoration-none">Sign up</a>
                        </p>
                    </div>

                    <?php echo $validLogin; ?>

                    <div class="login_button text-center">
                        <button type="submit" value="login" name="login" class="btn btn-primary mt-5">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>