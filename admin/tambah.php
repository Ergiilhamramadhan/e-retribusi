<?php
include '../../koneksi.php';

mysqli_query($conn, "INSERT INTO pelanggan 
(nama_toko,pemilik,alamat,nominal,status)
VALUES
('$_POST[nama_toko]','$_POST[pemilik]','$_POST[alamat]','$_POST[nominal]','$_POST[status]')");

header("Location: ../dashboard.php");