<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

// SEARCH
$cari = isset($_GET['cari']) ? mysqli_real_escape_string($conn, $_GET['cari']) : '';

$query = "SELECT * FROM pelanggan 
          WHERE nama_toko LIKE '%$cari%' 
          OR pemilik LIKE '%$cari%' 
          ORDER BY id DESC";

$data = mysqli_query($conn, $query);

// STATISTIK
$total = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pelanggan"));
$lunas = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pelanggan WHERE status='Lunas'"));
$belum = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pelanggan WHERE status='Belum'"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Retribusi Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="main-container">
    
    <div class="header-orange">
        <div class="brand" onclick="location.reload();" style="cursor: pointer;">
            <h2 style="margin:0; font-size: 20px;">E-RETRIBUSI</h2>
        </div>
        <div class="user-menu">
            <span>Selamat datang, <strong><?= $_SESSION['username']; ?> 👋</strong></span>
            <a href="../logout.php" class="btn-keluar">Keluar</a>
        </div>
    </div>

    <div class="content-padding">
        
        <div class="cards-wrapper">
            <div class="card-stat bg-blue">
                <small>Total Pelanggan</small>
                <h2><?= $total ?></h2>
            </div>
            <div class="card-stat bg-green">
                <small>Total Lunas</small>
                <h2><?= $lunas ?></h2>
            </div>
            <div class="card-stat bg-red">
                <small>Belum Bayar</small>
                <h2><?= $belum ?></h2>
            </div>
        </div>

        <div class="white-box">
            <div class="top-table">
                <form method="GET" class="search-container">
                    <input type="text" name="cari" class="search-input" placeholder="Cari toko atau pemilik..." value="<?= htmlspecialchars($cari) ?>">
                    <button type="submit" class="search-btn">Cari</button>
                </form>

                <button class="btn-tambah" onclick="document.getElementById('modal').style.display='flex'">
                    + Tambah Pelanggan
                </button>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Toko</th>
                            <th>Pemilik</th>
                            <th>Alamat</th>
                            <th>Nominal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(mysqli_num_rows($data) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($data)) : ?>
                            <tr>
                                <td><strong><?= $row['nama_toko'] ?></strong></td>
                                <td><?= $row['pemilik'] ?></td>
                                <td><?= $row['alamat'] ?></td>
                                <td>Rp <?= number_format($row['nominal'], 0, ',', '.') ?></td>
                                <td>
                                    <span class="badge <?= ($row['status'] == 'Lunas') ? 'lunas' : 'belum' ?>">
                                        <?= $row['status'] ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="proses/hapus.php?id=<?= $row['id'] ?>" class="btn-hapus" onclick="return confirm('Hapus data ini?')">Hapus</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="6" style="text-align:center;">Data tidak ditemukan.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Tambah Pelanggan</h3>
            <span class="close" style="cursor:pointer" onclick="document.getElementById('modal').style.display='none'">&times;</span>
        </div>
        <hr>
        <form action="proses/tambah.php" method="POST">
            <input type="text" name="nama_toko" placeholder="Nama Toko" required>
            <input type="text" name="pemilik" placeholder="Nama Pemilik" required>
            <textarea name="alamat" placeholder="Alamat Lengkap" required></textarea>
            <input type="number" name="nominal" placeholder="Nominal (Contoh: 50000)" required>

            <select name="status">
                <option value="Lunas">Lunas</option>
                <option value="Belum">Belum</option>
            </select>

            <button type="submit" class="btn-simpan">Simpan Data</button>
        </form>
    </div>
</div>

</body>
</html>