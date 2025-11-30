<?php
// vetheader.php
session_start();

if (!isset($_SESSION['vetID'])) {
    header("Location: userlogin.php");
    exit();
}

include "connection.php";  // contains $conn (MySQLi)

// Prepare and bind (MySQLi)
$stmt = $conn->prepare("
    SELECT vet_id, vet_name, phone_num, email, specialization, availability, username 
    FROM veterinarian 
    WHERE vet_id = ?
");

$stmt->bind_param("i", $_SESSION['vetID']);
$stmt->execute();

$result = $stmt->get_result();
$vet = $result->fetch_assoc();

$stmt->close();
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
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Lato:wght@300;400;700&family=Raleway:wght@300;400;500;600;700&display=swap"
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
            <a href="vethome.php" class="logo d-flex align-items-center me-auto me-xl-0">
                <h1 class="sitename">VetClinic</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="vethome.php" class="active">Home</a></li>
                    <li class="dropdown"><a href="#"><span>Appointment</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="">View Appointment</a></li>
                        </ul>
                    </li>
                    <li class="dropdown"><a href="#"><span>Patient Records</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="">Assigned Patient</a></li>
                        </ul>
                    </li>
                    <li class="dropdown"><a href="#"><span>Treatment</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="treatment1.php">Add treatment</a></li>
                        </ul>
                    </li>
                    <li class="dropdown"><a href="#"><span>Med Usage</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="">Check Stock</a></li>
                        </ul>
                    </li>
                    <li class="dropdown"><a href="#"><span>MyProfile</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="vetprofile.php">Update Profile</a></li>
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
    <!-- End Header -->

    <!-- Vendor JS -->
    <script src="MediTrust/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="MediTrust/assets/vendor/aos/aos.js"></script>
    <script src="MediTrust/assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="MediTrust/assets/vendor/glightbox/js/glightbox.min.js"></script>

    <script src="MediTrust/assets/js/main.js"></script>

    <script>
        AOS.init();
    </script>

</body>
</html>
