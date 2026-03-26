<?php
session_start();
session_destroy(); // hapus semua session
header("Location: index.php"); // kembali ke login
exit;
?>