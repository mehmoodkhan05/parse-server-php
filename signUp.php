<?php


include 'navbar.php';
include('./db/connection.php');
include('vendor/autoload.php');

use Parse\ParseObject;
use Parse\ParseException;
use Parse\ParseQuery;

$emailExistError = '';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];

    // FileUpload
    $file = $_FILES['fileUpload'];
    $file_name = $file['name'];
    $file_name = preg_replace("/\s+/", "", $file_name);
    $temp = $file['tmp_name'];

    // Generate new file name
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $file_name = pathinfo($file_name, PATHINFO_FILENAME);
    $newName = $file_name . date("miYis") . '.' . $file_ext;
    $saveto = "./images/" . $newName;

    if (move_uploaded_file($temp, $saveto)) {
        // File uploaded successfully
        // Create new ParseObject for user registration

        $user = new ParseObject('userRegistration');
        $user->set("name", $name);
        $user->set("email", $email);
        $user->set("phone", $phone);
        $user->set("dob", $dob);
        $user->set("gender", $gender);
        $user->set("password", $password);

        // Hashed Password
        // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // $user->set("password", $hashed_password);

        // Save image path to Parse
        $user->set("fileUpload", $saveto);

        // Check if email already exists
        $query = new ParseQuery('userRegistration');
        $query->equalTo("email", $email);
        $result = $query->find();

        if (count($result) > 0) {
            // Email already exists
            $emailExistError = '<div class="alert alert-danger text-center">Email Already exists</div>';
        } else {
            // Save user to Parse
            try {
                $user->save();
                echo "<script>window.location.href = 'login.php';</script>";
                exit();
            } catch (ParseException $e) {
                echo "<div class='alert alert-danger'>('Error: " . $e->getMessage() . "')</div>";
            }
        }
    } else {
        // Error uploading file
        echo "<div class='alert alert-danger'>Error File Uploading</div>";
    }
}


    // $selectQuery = mysqli_query($conn, "SELECT * FROM signup WHERE `email` = '$email'");
    // $rowCount = mysqli_num_rows($selectQuery);

//     if ($rowCount > 0) {
//         $emailExistError = '
//         <div class="alert alert-danger text-center">Email Already exists</div>
//         ';
//     } else {
//         $query = mysqli_query($conn, "INSERT INTO signup (`name`, `email`, `phone`, `dob`, `gender`, `password`, `image`) VALUES ('$name', '$email', '$phone', '$dob', '$gender', '$password', '$saveto')");

//         if ($query) {
//             echo "<script>window.location.href = 'login.php';</script>";
//             exit();
//         } else {
//             echo "<script>alert('Something went wrong!')</script>";
//         }
//     }
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/style.css">

    <style>
        .form-control {
            border: none;
            border-bottom: 1px solid #0dcaf0;
        }

        .form-control:focus {
            box-shadow: none;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Sign Up</h2>
        <div class="row justify-content-center">
            <div class="col-6">
                <!-- Error Here -->
                <?php echo $emailExistError; ?>
                <form class="signup_form" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="username">Your Name:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="email">Email Address:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="phone">Phone Number:</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="dob">Date of Birth:</label>
                        <input type="date" class="form-control" id="dob" name="dob" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="gender">Gender:</label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="select" hidden>Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label for="password">Enter Your Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group mt-4">
                        <label for="profile">Upload Picture:</label>
                        <input type="file" class="form-control mt-3" id="fileUpload" name="fileUpload" accept="image/*" required>
                    </div>
                    <div class="text-center mt-4">
                        <p>Already a member?
                            <a href="login.php" class="text-decoration-none">login</a>
                        </p>
                    </div>
                    <div class="signup_button text-center mb-2 mt-5">
                        <button type="submit" name="submit" action="login.php" class="btn btn-primary">Sign Up</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>