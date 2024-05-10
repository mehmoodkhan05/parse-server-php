<?php
include("navbar.php");
include("./db/connection.php");
include("vendor/autoload.php");

use Parse\ParseException;
use Parse\ParseQuery;

// Check if user is logged in
if (empty($_SESSION['email'])) {
    header("LOCATION: login.php");
    exit();
}

$userEmail = $_SESSION['email'];

// Query Parse User object to fetch user data
$query = new ParseQuery('userRegistration');
$query->equalTo('email', $userEmail);

try {
    $user = $query->first();
    if ($user) {
        // Check if form is submitted for update
        if (isset($_POST['updateData'])) {
            // Retrieve user data
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $dob = $_POST['dob'];
            $gender = $_POST['gender'];
            $password = $_POST['password'];
            $profileImage = $_POST['fileUpload'];

            // Handle profile image upload
            if ($_FILES['fileUpload']['error'] === UPLOAD_ERR_OK) {
                $tmpFilePath = $_FILES['fileUpload']['tmp_name'];
                $newFilePath = 'images/' . $_FILES['fileUpload']['name']; // Adjust path as needed

                // Move uploaded file to destination
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    // Delete old profile image file if it exists
                    $oldFilePath = $user->get('fileUpload');
                    if ($oldFilePath && file_exists($oldFilePath)) {
                        unlink($oldFilePath); // Delete old image file
                    }
                    // Update user data including new image path
                    $user->set('fileUpload', $newFilePath);
                }
            }

            // Update user data
            $user->set('name', $name);
            $user->set('phone', $phone);
            $user->set('dob', $dob);
            $user->set('gender', $gender);
            $user->set('password', $password);

            // Check if profile image is set or use default path
            $defaultProfileImagePath = 'path_to_default_image.jpg'; // Replace with your default image path

            // Check if $profileImage is empty or null, then set it to default path
            if (empty($profileImage)) {
                $profileImage = $defaultProfileImagePath;
            }

            // Update user data
            $user->save();

            // Set session variable to indicate changes saved
            $_SESSION['changesSaved'] = true;

            // Redirect to prevent form resubmission on page refresh
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
        // Retrieve user data for displaying in the form
        $name = $user->get('name');
        $phone = $user->get('phone');
        $dob = $user->get('dob');
        $gender = $user->get('gender');
        $hashedPassword = $user->get('password');
        // Assuming 'fileUpload' is the field name for profile image
        $profileImage = $user->get('fileUpload');
    } else {
        $errorMessage = "<div class='alert alert-danger text-center'>Error updating profile!</div>";
        exit();
    }
} catch (ParseException $e) {
    echo 'Error: ' . $e->getMessage();
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="css/style.css">

    <style>
        .form-control {
            border: none;
            border-bottom: 1px solid #0dcaf0;
        }

        .form-control:focus {
            box-shadow: none;
        }

        .image-data {
            margin-top: 112px;
        }
    </style>
</head>

<body>
    <form class="edit_profile_form" method="POST" enctype="multipart/form-data">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-lg-4 left-side">
                    <div class="form-group image-data text-center">
                        <img name="profileImage" id="profileImage" src="<?php echo htmlspecialchars($profileImage); ?>" class="img-thumbnail" width="250" alt="Profile Picture">
                    </div>
                    <div class="form-group mt-4">
                        <label for="profile_pic">Update Picture:</label>
                        <input type="file" class="form-control mt-3" id="fileUpload" name="fileUpload" accept="image/*">
                    </div>
                </div>
                <div class="col-lg-8 col-md-6 right-side">
                    <h2 class="mb-4 text-center">Update Profile</h2>

                    <input type="hidden" value="<?php echo htmlspecialchars($userEmail); ?>" name="userEmail">
                    <div class="form-group">
                        <label for="name">Your Name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                    </div>
                    <div class="form-group mt-4">
                        <label for="email">Email Address:</label>
                        <input style="background: none; cursor:not-allowed" disabled type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($userEmail); ?>" required>
                    </div>
                    <div class="form-group mt-4">
                        <label for="phone">Phone Number:</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>
                    </div>
                    <div class="form-group mt-4">
                        <label for="dob">Date of Birth:</label>
                        <input type="date" class="form-control" id="dob" name="dob" value="<?php echo htmlspecialchars($dob); ?>" required>
                    </div>
                    <div class="form-group mt-4">
                        <label for="gender">Gender:</label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="male" <?php echo ($gender === 'male') ? 'selected' : ''; ?>>Male</option>
                            <option value="female" <?php echo ($gender === 'female') ? 'selected' : ''; ?>>Female</option>
                            <option value="other" <?php echo ($gender === 'other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                    <div class="form-group mt-4">
                        <label for="password">Password:</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($hashedPassword); ?>" id="password" name="password" required>
                    </div>

                    <?php
                    // Display "Changes Saved" message if changes were successfully saved
                    if (isset($_SESSION['changesSaved']) && $_SESSION['changesSaved']) {
                        echo "<div class='alert alert-success text-center mt-4'>Changes Saved!</div>";
                        // Unset the session variable to prevent showing the message again on page refresh
                        unset($_SESSION['changesSaved']);
                    }
                    ?>

                    <?php echo isset($errorMessage) ? $errorMessage : ''; ?>

                    <div class="text-center mt-4 mb-2">
                        <button type="submit" class="btn btn-primary" name="updateData">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>

</html>