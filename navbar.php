<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <style>
        .dropdown-item {
            margin: 0;
            padding: 0 25px;
            /* line-height: 0; */
        }

        .slide {
            /* clear: both; */
            width: 100%;
            overflow: hidden;
            text-align: center;
            transition: height .4s ease;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 fs-5">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                    </li>
                </ul>
                <div class="right-side" id="navbarNavDropdown">
                    <ul class="navbar-nav fs-5">
                        <?php
                        session_start();

                        if (isset($_SESSION['email'])) {
                        ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </a>
                                <ul class="dropdown-menu slide w-50" aria-labelledby="navbarDropdown" style="left: -130px;">
                                    <li>
                                        <a class="dropdown-item m-0" href="profile.php">Profile</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item m-0" href="signout.php">Logout</a>
                                    </li>
                                </ul>
                            </li>
                        <?php
                        } else {
                        ?>
                            <li class="nav-item me-4">
                                <a class="nav-link" href="login.php">Login</a>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

</body>

</html>