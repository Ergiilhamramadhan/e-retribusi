<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'petugas') {
    header('Location: ../index.php');
    exit();
}

// Logout handler
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ../index.php');
    exit();
}

// Mock Data - Biasanya ini diambil dari Database (MySQL)
$daftar_pelanggan = [
    ['id' => '101', 'nama' => 'Budi Santoso', 'alamat' => 'Blok A No. 5', 'status' => 'Belum Bayar'],
    ['id' => '102', 'nama' => 'Toko Maju Jaya', 'alamat' => 'Jl. Raya No. 10', 'status' => 'Lunas'],
    ['id' => '103', 'nama' => 'Siti Aminah', 'alamat' => 'RT 03 RW 02', 'status' => 'Belum Bayar'],
];

// Tarif retribusi per hari (dalam Rupiah)
const TARIF_PER_HARI = 5000;

// Simulasi logika POST (Simpan Data)
$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['bayar'])) {
    // Di sini biasanya ada query INSERT/UPDATE ke database
    $message = "success";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Retribusi Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="bg-slate-50 text-slate-900 pb-32">

    <nav class="fixed top-0 w-full bg-white/80 backdrop-blur-md border-b z-50 p-4">
        <div class="max-w-3xl mx-auto flex justify-between items-center">
            <h1 class="font-extrabold text-blue-600 tracking-tight text-xl">E-RETRIBUSI</h1>
            <div class="flex items-center gap-3">
                <span class="text-xs font-bold bg-slate-100 px-3 py-1 rounded-full text-slate-500">
                    Petugas: <?= htmlspecialchars($_SESSION['user']) ?>
                </span>
                <a href="?logout=1" class="text-xs font-bold bg-red-100 px-3 py-1 rounded-full text-red-600 hover:bg-red-200 transition-all">
                    Keluar
                </a>
            </div>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto px-4 pt-24 space-y-6">
        
        <?php if ($message == "success"): ?>
        <div class="bg-emerald-500 text-white p-4 rounded-2xl shadow-lg flex items-center gap-3 animate-bounce">
            <span>✅</span>
            <p class="font-bold text-sm">Pembayaran Berhasil Disimpan & Dikunci!</p>
        </div>
        <?php endif; ?>

        <form method="POST" id="formRetribusi">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200 mb-6">
                <label class="block text-sm font-extrabold text-slate-700 mb-3">1. Identitas Wajib Retribusi:</label>
                <select name="pelanggan" id="pelanggan" required onchange="cekStatus()" class="w-full p-4 rounded-xl bg-slate-50 border border-slate-200 font-bold outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Pelanggan --</option>
                    <?php foreach($daftar_pelanggan as $p): ?>
                        <option value="<?= $p['id'] ?>" data-status="<?= $p['status'] ?>">
                            <?= $p['nama'] ?> (<?= $p['status'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div id="formKonten" class="space-y-6">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-blue-100">
                    <div class="mb-5 border-b pb-3">
                        <span class="text-xs font-black text-blue-600 uppercase">Periode Pembayaran</span>
                        <h2 class="text-lg font-extrabold text-slate-800">Pilih Durasi Retribusi</h2>
                        <p class="text-xs text-slate-500 mt-1">Tarif: Rp <?= number_format(TARIF_PER_HARI, 0, ',', '.') ?> / hari</p>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-6">
                        <label class="cursor-pointer">
                            <input type="radio" name="durasi" value="hari" class="hidden peer" onchange="hitungTotal()" checked>
                            <div class="p-4 rounded-2xl border-2 border-slate-100 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all">
                                <span class="text-sm font-bold text-slate-600 block">Per Hari</span>
                                <span class="text-xs text-slate-400">Setor 1 hari</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="durasi" value="bulan" class="hidden peer" onchange="hitungTotal()">
                            <div class="p-4 rounded-2xl border-2 border-slate-100 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all">
                                <span class="text-sm font-bold text-slate-600 block">Per Bulan</span>
                                <span class="text-xs text-slate-400">Setor 30 hari</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="durasi" value="tahun" class="hidden peer" onchange="hitungTotal()">
                            <div class="p-4 rounded-2xl border-2 border-slate-100 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all">
                                <span class="text-sm font-bold text-slate-600 block">Per Tahun</span>
                                <span class="text-xs text-slate-400">Setor 365 hari</span>
                            </div>
                        </label>
                    </div>

                    <div id="jumlahHariContainer" class="mt-4">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Atau Masukkan Jumlah Hari (opsional):</label>
                        <input type="number" id="jumlahHari" name="jumlah_hari" min="1" max="365" placeholder="Contoh: 7 (untuk 7 hari)" class="w-full p-3 rounded-xl bg-slate-50 border border-slate-200 font-bold outline-none focus:ring-2 focus:ring-blue-500" oninput="hitungTotal()">
                        <p class="text-xs text-slate-400 mt-1">* Kosongkan jika memilih periode di atas</p>
                    </div>
                </div>
            </div>

            <div id="lockMessage" class="hidden bg-amber-50 border border-amber-200 p-4 rounded-2xl flex gap-3 mt-6">
                <span class="text-lg">🔒</span>
                <p class="text-xs text-amber-700 font-bold">Data ini sudah Lunas. Transaksi tidak dapat diubah kembali untuk menjaga validitas data.</p>
            </div>

            <div class="fixed bottom-0 left-0 right-0 bg-white border-t p-4 shadow-[0_-15px_30px_rgba(0,0,0,0.08)] z-50">
                <div class="max-w-3xl mx-auto flex justify-between items-center px-4">
                    <div class="flex-1">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Tagihan</p>
                        <p class="text-2xl font-black text-blue-600 mt-1" id="displayTotal">Rp 0</p>
                        <p class="text-xs text-slate-400 mt-1" id="detailTotal"></p>
                    </div>
                    <div class="flex gap-2 w-1/2">
                        <button type="submit" name="bayar" id="btnBayar" class="w-full bg-blue-600 text-white font-black py-4 rounded-2xl shadow-xl hover:bg-blue-700 active:scale-95 transition-all text-sm uppercase tracking-widest">
                            Simpan & Bayar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <script>
        const TARIF_PER_HARI = 5000;

        function hitungTotal() {
            let total = 0;
            let hari = 0;
            
            // Ambil durasi yang dipilih
            const durasi = document.querySelector('input[name="durasi"]:checked');
            // Ambil jumlah hari custom
            const jumlahHariInput = document.getElementById('jumlahHari');
            let customHari = parseInt(jumlahHariInput.value);
            
            // Hitung berdasarkan durasi atau custom hari
            if (durasi) {
                switch(durasi.value) {
                    case 'hari':
                        hari = 1;
                        break;
                    case 'bulan':
                        hari = 30;
                        break;
                    case 'tahun':
                        hari = 365;
                        break;
                }
            }
            
            // Jika custom hari diisi, override durasi yang dipilih
            if (!isNaN(customHari) && customHari > 0) {
                hari = customHari;
                // Batasi maksimal 365 hari
                if (hari > 365) {
                    hari = 365;
                    jumlahHariInput.value = 365;
                }
            }
            
            total = hari * TARIF_PER_HARI;
            
            // Format tampilan detail
            let detailText = "";
            if (hari === 1) {
                detailText = "Pembayaran untuk 1 hari";
            } else if (hari === 30) {
                detailText = "Pembayaran untuk 1 bulan (30 hari)";
            } else if (hari === 365) {
                detailText = "Pembayaran untuk 1 tahun (365 hari)";
            } else if (hari > 0) {
                detailText = `Pembayaran untuk ${hari} hari`;
            }
            
            document.getElementById('displayTotal').innerText = "Rp " + total.toLocaleString('id-ID');
            document.getElementById('detailTotal').innerHTML = detailText ? `<span class="font-medium">${detailText}</span>` : '';
        }

        function cekStatus() {
            const select = document.getElementById('pelanggan');
            const selectedOption = select.options[select.selectedIndex];
            const status = selectedOption.getAttribute('data-status');
            const formKonten = document.getElementById('formKonten');
            const btnBayar = document.getElementById('btnBayar');
            const lockMessage = document.getElementById('lockMessage');

            if (status === "Lunas") {
                formKonten.style.opacity = "0.5";
                formKonten.style.pointerEvents = "none";
                btnBayar.disabled = true;
                btnBayar.innerText = "LUNAS / TERKUNCI";
                btnBayar.classList.replace('bg-blue-600', 'bg-slate-300');
                lockMessage.classList.remove('hidden');
            } else {
                formKonten.style.opacity = "1";
                formKonten.style.pointerEvents = "auto";
                btnBayar.disabled = false;
                btnBayar.innerText = "Simpan & Bayar";
                btnBayar.classList.replace('bg-slate-300', 'bg-blue-600');
                lockMessage.classList.add('hidden');
            }
        }
        
        // Panggil hitungTotal saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            hitungTotal();
        });
    </script>
</body>
</html>