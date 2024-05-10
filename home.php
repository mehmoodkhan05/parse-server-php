<?php
include("navbar.php");
include("./db/connection.php");
require("vendor/autoload.php");

use Parse\ParseUser;

if (empty($_SESSION['email'])) {
    header("LOCATION: login.php");
}

// Retrieve user's email from session
$email = $_SESSION['email'];

// Fetch user data
$user = ParseUser::getCurrentUser();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .home-page .main-col {
            box-shadow: 1px 1px 8px 8px gainsboro;
            padding: 80px 0;
        }
    </style>
</head>

<body>
    <div class="home-page text-center mt-5">
        <div class="row justify-content-center m-0">
            <div class="col-6 main-col">
                <h1 class="">Welcome Home!</h1>
            </div>
        </div>
    </div>
</body>

</html>