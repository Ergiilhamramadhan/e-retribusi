<?php
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
$data = mysqli_fetch_assoc($query);

if ($data) {
    $_SESSION['login'] = true;
    $_SESSION['username'] = $data['username'];
    $_SESSION['role'] = $data['role'];

    // Arahkan berdasarkan role
    if ($data['role'] == 'admin') {
        header("Location: admin/dashboard.php");
    } else if ($data['role'] == 'petugas') {
        header("Location: petugas/dashboard.php");
    }
} else {
    echo "Login gagal!";
}
?>