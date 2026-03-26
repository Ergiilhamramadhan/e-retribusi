<?php
session_start();
include '../koneksi.php';

// CEK LOGIN
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'petugas') {
    header("Location: ../index.php");
    exit;
}

if (!isset($_SESSION['area'])) {
    header("Location: ../index.php");
    exit;
}

$area = $_SESSION['area']; // 🔥 ambil area dari login
?>

<!DOCTYPE html>
<html>
<head>
    <title>Petugas Area</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="container">
    <h2>Petugas Area Jalan <?= $area; ?></h2>

    <table border="1" width="100%">
        <tr>
            <th>Nama Toko</th>
            <th>Tagihan</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        <?php
        $data = mysqli_query($conn, "SELECT * FROM pelanggan WHERE area='$area'");

        while($d = mysqli_fetch_array($data)){
        ?>
        <tr>
            <td><?= $d['nama_toko']; ?></td>
            <td><?= $d['tagihan']; ?></td>
            <td><?= $d['status']; ?></td>
            <td>
                <a href="bayar.php?id=<?= $d['id']; ?>">Bayar</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>