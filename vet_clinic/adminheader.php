<?php
//adminheader.php

session_start();

if (!isset($_SESSION['adminID'])) {
    header("Location: userlogin.php");
    exit();
}


include "connection.php";
$stmt = $conn->prepare("SELECT admin_id, admin_name FROM clinic_administrator WHERE admin_id = :admin_id");
$stmt->execute([':admin_id' => $_SESSION['adminID']]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>VetClinic</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="MediTrust/assets/img/favicon.png" rel="icon">
    <link href="MediTrust/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&family=Lato:wght@100;300;400;700;900&family=Raleway:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="MediTrust/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="MediTrust/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="MediTrust/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="MediTrust/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="MediTrust/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="MediTrust/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="MediTrust/assets/css/main.css" rel="stylesheet">
</head>

<body class="index-page">

    <!-- ======= Header ======= -->
    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="header-container container-fluid container-xl d-flex align-items-center justify-content-between">
            <a href="adminhome.php" class="logo d-flex align-items-center me-auto me-xl-0">
                <h1 class="sitename">VetClinic</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="adminhome.php" class="active">Home</a></li>

                    <li class="dropdown"><a href="#"><span>Veterinarian</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="vetregister.php">Register Vet</a></li>
                            <li><a href="vetlist.php">List Vet</a></li>
                        </ul>
                    </li>

                    <li class="dropdown"><a href="#"><span>Patient</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="viewpatient.php">View Patient</a></li>
                        </ul>
                    </li>

                    <li class="dropdown"><a href="#"><span>Medicine</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href=".php">Add Medicine</a></li>
                            <li><a href=".php">View Medicine</a></li>
                            <li><a href=".php">Stock Medicine</a></li>
                        </ul>
                    </li>

                    <li class="dropdown"><a href="#"><span>Treatment</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="treatment.php">Add Treatment</a></li>
                            <li><a href=".php">View Treatment</a></li>
                        </ul>
                    </li>

                    <li class="dropdown"><a href="#"><span>Appointment</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href=".php">View Appointment</a></li>
                            <li><a href=".php">Monitor Appointment</a></li>
                        </ul>
                    </li>

                    <li><a href=".php">Reports</a></li>

                    <li class="dropdown"><a href="#"><span>Setting</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href=".php">Audit Log</a></li>
                        </ul>
                    </li>

                    <li class="dropdown"><a href="#"><span>MyProfile</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="adminprofile.php">Update Profile</a></li>
                        </ul>
                    </li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <a href="notification.php" class="me-3">
                <i class="bi bi-bell fs-4"></i>
            </a>
            <a class="btn-getstarted" href="logout.php">Log out</a>
        </div>
    </header>
