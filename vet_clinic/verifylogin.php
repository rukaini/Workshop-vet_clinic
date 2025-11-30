<?php
// verifylogin.php
session_start();
include "connection.php";  // mysqli connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // ---------------------------
    // 1. Check ADMIN
    // ---------------------------
    $sql = "SELECT admin_id, username, password 
            FROM clinic_administrator 
            WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();
        $_SESSION['adminID'] = $admin['admin_id'];
        $_SESSION['username'] = $admin['username'];

        header("Location: adminhome.php");
        exit();
    }

    // ---------------------------
    // 2. Check VET
    // ---------------------------
    $sql = "SELECT vet_id, username, password 
            FROM veterinarian
            WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $vet = $result->fetch_assoc();
        $_SESSION['vetID'] = $vet['vet_id'];
        $_SESSION['username'] = $vet['username'];

        header("Location: vethome.php");
        exit();
    }

    // ---------------------------
    // 3. Check OWNER
    // ---------------------------
    $sql = "SELECT owner_id, username, password 
            FROM owner
            WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $owner = $result->fetch_assoc();
        $_SESSION['ownerID'] = $owner['owner_id'];
        $_SESSION['username'] = $owner['username'];

        header("Location: ownerhome.php");
        exit();
    }

    // ---------------------------
    // Invalid login
    // ---------------------------
    echo "<script>
            alert('Invalid username or password!');
            window.location='userlogin.php';
          </script>";
}
?>
