<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../dasboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan - E-Retribusi DLH Sragen</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f9; /* Latar Abu Muda */
            color: #333;
        }

        /* Styling Header (Sama dengan Dashboard Utama) */
        .navbar-custom {
            background-color: #ff6600; /* Warna Oranye Utama kamu */
            color: white;
            padding: 15px 20px;
            border-bottom: 3px solid #e65c00;
        }
        .navbar-brand-custom {
            font-weight: 700;
            font-size: 24px;
            color: white !important;
            text-decoration: none;
        }
        .btn-keluar {
            background-color: #ffcc00; /* Warna Kuning Tombol kamu */
            color: #333;
            border: none;
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        .btn-keluar:hover {
            background-color: #e6b800;
        }

        /* Styling Main Card (Area Putih Besar) */
        .card-main {
            background-color: #ffffff;
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05); /* Soft Shadow */
            padding: 25px;
            margin-top: 20px;
        }
        .card-title-custom {
            font-weight: 700;
            color: #333;
            margin: 0;
        }

        /* Styling Form Pencarian & Tombol Tambah */
        .search-box {
            border-radius: 50px;
            padding-left: 15px;
            border: 1px solid #dee2e6;
        }
        .btn-tambah {
            background-color: #ff6600;
            color: white;
            border: none;
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 50px;
        }
        .btn-tambah:hover {
            background-color: #e65c00;
            color: white;
        }

        /* Styling Tabel */
        .table-custom th {
            font-weight: 600;
            color: #6c757d;
            border-bottom: 2px solid #dee2e6;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
        }
        .table-custom tbody tr {
            transition: background-color 0.2s ease;
        }
        .table-custom tbody tr:hover {
            background-color: #fff8f4; /* Highlight Oranye Tipis saat Hover */
        }
        
        /* Badges untuk Wilayah */
        .badge-wilayah-1 {
            background-color: #e8f0fe;
            color: #1a73e8;
            padding: 5px 10px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 600;
        }
        .badge-wilayah-2 {
            background-color: #fef7e0;
            color: #f9ab00;
            padding: 5px 10px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 600;
        }

        /* Styling Modal (Pop-up Tambah/Edit) */
        .modal-content {
            border-radius: 15px;
            border: none;
        }
        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        .form-label {
            font-weight: 600;
            font-size: 14px;
            color: #555;
        }
        .form-control, .form-select {
            border-radius: 8px;
            padding: 10px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-custom">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a href="admin_dashboard.html" class="navbar-brand-custom">
                <i class="fas fa-arrow-left me-2 fs-5"></i>E-RETRIBUSI
            </a>
            
            <div class="d-flex align-items-center gap-3">
                <div class="text-end text-white">
                    <div class="fw-bold">ADMIN</div>
                    <div class="small opacity-75">SRAGEN DLH</div>
                </div>
                <button class="btn btn-keluar">
                    <i class="fas fa-sign-out-alt me-2"></i>KELUAR
                </button>
            </div>
        </div>
    </nav>

    <div class="container-fluid p-4">
        
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="admin_dashboard.html" class="text-decoration-none text-muted">Dashboard</a></li>
                <li class="breadcrumb-item active fw-bold text-orange" aria-current="page">Data Pelanggan</li>
            </ol>
        </nav>

        <div class="card-main">
            
            <div class="row align-items-center mb-4 g-3">
                <div class="col-md-4">
                    <h3 class="card-title-custom">
                        <i class="fas fa-store text-orange me-2"></i>Manajemen Data Pelanggan
                    </h3>
                    <p class="text-muted small m-0">Total: 120 Toko/Wajib Retribusi Terdaftar</p>
                </div>
                
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 search-box"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" class="form-control border-start-0 search-box" placeholder="Cari Nama Toko, Pemilik, atau ID...">
                    </div>
                </div>
                
                <div class="col-md-3 text-md-end">
                    <button class="btn btn-tambah w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#modalTambahPelanggan">
                        <i class="fas fa-plus-circle me-2"></i>TAMBAH PELANGGAN
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-custom table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>NAMA TOKO</th>
                            <th>NAMA PEMILIK</th>
                            <th>ALAMAT LENGKAP</th>
                            <th>WILAYAH</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-bold text-muted">P-001</td>
                            <td class="fw-bold">Toko Makmur Jaya</td>
                            <td>Bapak Budi Santoso</td>
                            <td>Jl. Raya Sragen No. 10, Sidoharjo</td>
                            <td><span class="badge-wilayah-1">Utara (1)</span></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-light text-warning rounded-circle" title="Edit Data" data-bs-toggle="modal" data-bs-target="#modalEditPelanggan"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-light text-danger rounded-circle" title="Hapus Data"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">P-002</td>
                            <td class="fw-bold">Warung Mbak Sri</td>
                            <td>Ibu Sri Wahyuni</td>
                            <td>Pasar Bunder Stand No. 5</td>
                            <td><span class="badge-wilayah-2">Selatan (2)</span></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-light text-warning rounded-circle" title="Edit Data"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-light text-danger rounded-circle" title="Hapus Data"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">P-003</td>
                            <td class="fw-bold">Toko Kelontong Sejahtera</td>
                            <td>Bapak Agus Setiawan</td>
                            <td>Jl. Veteran No. 3, Karangmalang</td>
                            <td><span class="badge-wilayah-1">Utara (1)</span></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-light text-warning rounded-circle" title="Edit Data"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-light text-danger rounded-circle" title="Hapus Data"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted small">Menampilkan 1-10 dari 120 pelanggan</div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination pagination-sm m-0">
                        <li class="page-item disabled"><a class="page-link" href="#">Sebelumnya</a></li>
                        <li class="page-item active"><a class="page-link bg-orange border-orange" href="#">1</a></li>
                        <li class="page-item"><a class="page-link text-orange" href="#">2</a></li>
                        <li class="page-item"><a class="page-link text-orange" href="#">3</a></li>
                        <li class="page-item"><a class="page-link text-orange" href="#">Berikutnya</a></li>
                    </ul>
                </nav>
            </div>

        </div>
        
    </div>

    <div class="modal fade" id="modalTambahPelanggan" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalTambahLabel"><i class="fas fa-plus-circle text-orange me-2"></i>Tambah Pelanggan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="idPelanggan" class="form-label">ID Pelanggan</label>
                                <input type="text" class="form-control bg-light" id="idPelanggan" value="P-004 (Otomatis)" readonly>
                            </div>
                            <div class="col-md-8">
                                <label for="namaToko" class="form-label">Nama Toko / Usaha</label>
                                <input type="text" class="form-control" id="namaToko" placeholder="Masukkan nama toko..." required>
                            </div>
                            <div class="col-md-6">
                                <label for="namaPemilik" class="form-label">Nama Pemilik</label>
                                <input type="text" class="form-control" id="namaPemilik" placeholder="Masukkan nama pemilik..." required>
                            </div>
                            <div class="col-md-6">
                                <label for="noTelp" class="form-label">No. Telepon / WhatsApp</label>
                                <input type="tel" class="form-control" id="noTelp" placeholder="08xxxxxxxxxx">
                            </div>
                            <div class="col-12">
                                <label for="alamat" class="form-label">Alamat Lengkap</label>
                                <textarea class="form-control" id="alamat" rows="3" placeholder="Masukkan alamat lengkap toko..." required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="wilayah" class="form-label">Wilayah Penagihan</label>
                                <select class="form-select" id="wilayah" required>
                                    <option value="" selected disabled>Pilih Wilayah...</option>
                                    <option value="1">Utara (Petugas 1)</option>
                                    <option value="2">Selatan (Petugas 2)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="nominal" class="form-label">Nominal Retribusi (Rp)</label>
                                <input type="number" class="form-control" id="nominal" placeholder="Contoh: 50000" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-top rounded-bottom-15">
                        <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-tambah rounded-pill px-4">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditPelanggan" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalEditLabel"><i class="fas fa-edit text-warning me-2"></i>Edit Data Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="editIdPelanggan" class="form-label">ID Pelanggan</label>
                                <input type="text" class="form-control bg-light" id="editIdPelanggan" value="P-001" readonly>
                            </div>
                            <div class="col-md-8">
                                <label for="editNamaToko" class="form-label">Nama Toko / Usaha</label>
                                <input type="text" class="form-control" id="editNamaToko" value="Toko Makmur Jaya" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editNamaPemilik" class="form-label">Nama Pemilik</label>
                                <input type="text" class="form-control" id="editNamaPemilik" value="Bapak Budi Santoso" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editNoTelp" class="form-label">No. Telepon / WhatsApp</label>
                                <input type="tel" class="form-control" id="editNoTelp" value="08123456789">
                            </div>
                            <div class="col-12">
                                <label for="editAlamat" class="form-label">Alamat Lengkap</label>
                                <textarea class="form-control" id="editAlamat" rows="3" required>Jl. Raya Sragen No. 10, Sidoharjo</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="editWilayah" class="form-label">Wilayah Penagihan</label>
                                <select class="form-select" id="editWilayah" required>
                                    <option value="1" selected>Utara (Petugas 1)</option>
                                    <option value="2">Selatan (Petugas 2)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="editNominal" class="form-label">Nominal Retribusi (Rp)</label>
                                <input type="number" class="form-control" id="editNominal" value="100000" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-top">
                        <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning text-dark rounded-pill px-4 fw-bold">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>