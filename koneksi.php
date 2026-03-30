<?php
$host = "localhost";     // server lokal
$user = "root";          // default XAMPP
$pass = "";              // default XAMPP kosong
$db   = "e-retribusi";     // nama database di phpMyAdmin kamu

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>