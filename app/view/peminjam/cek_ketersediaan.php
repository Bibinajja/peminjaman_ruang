<?php
// AMATI: Cara lama mengambil tanggal dari GET
$today = date('Y-m-d');
$tanggal_terpilih = $_GET['tanggal'] ?? $today;

// MODIFIKASI: Proteksi agar minimal hari ini
if ($tanggal_terpilih < $today) {
    $tanggal_terpilih = $today;
}

// TIRU: Logika filter dari kode lama Anda
$lokasi_filter = $_GET['lokasi'] ?? '';
$jenis_filter = $_GET['jenis'] ?? '';
$search = trim($_GET['search'] ?? '');

// MODIFIKASI: Karena sekarang menggunakan MVC, panggil Model melalui Controller
// Pastikan data ini dikirim dari Peminjam.php
$ruangan = $data['ruangan'] ?? []; 
?>
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyRoom - Cek Ketersediaan Ruangan</title>
    <link rel="stylesheet" href="<?= BASEURL ?>/assets/css/cek_ruangan.css">
</head>

<body>

    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <h2>MyRoom</h2>
            </div>
            <div class="nav-menu">
                <a href="<?= BASEURL ?>/peminjam/cek_ketersediaan" class="nav-link active">Cek Ruang</a>
                <a href="<?= BASEURL ?>/peminjam/form_peminjaman" class="nav-link">Formulir Peminjaman</a>
            </div>
            <div class="nav-actions">
                <a href="<?= BASEURL ?>/peminjam/riwayat" class="nav-icon" title="Riwayat">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 11l3 3L22 4"></path>
                        <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path>
                    </svg>
                </a>
                <a href="<?= BASEURL ?>/peminjam/profile" class="nav-icon" title="Profile">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <circle cx="12" cy="8" r="3"></circle>
                        <path d="M6.168 18.849A4 4 0 0110 16h4a4 4 0 013.834 2.855"></path>
                    </svg>
                </a>
            </div>
        </div>
    </nav>

<section class="search-section">
    <div class="search-container">
        <h1>Cek Ketersediaan Ruangan</h1>
        
        <form method="GET" action="<?= BASEURL ?>/peminjam/cek_ketersediaan" class="search-form">
            <input type="hidden" name="lokasi" value="<?= htmlspecialchars($data['lokasi'] ?? '') ?>">
            <input type="hidden" name="jenis" value="<?= htmlspecialchars($data['jenis'] ?? '') ?>">

            <div class="form-group">
                <label class="small fw-bold">Cari Ruangan</label>
                <input type="text" name="search" class="form-control" value="<?= htmlspecialchars($data['search'] ?? '') ?>" placeholder="Nama ruangan...">
            </div>
            
            <div class="form-group">
                <label class="small fw-bold text-primary">Tanggal Cek:</label>
                <input type="date" name="tanggal" id="tanggal-cek"
                       class="form-control border-primary fw-bold"
                       value="<?= $tanggal_terpilih ?>" 
                       min="<?= $today ?>"
                       onchange="this.form.submit()"> 
            </div>
            
            <button type="submit" class="btn-cek">Cek</button>
        </form>

        <div class="alert alert-info shadow-sm mt-4" style="border-left: 5px solid #0dcaf0; background: white; padding: 15px; border-radius: 8px; display: flex; align-items: center;">
            <i class="fas fa-calendar-alt fa-2x text-info me-3"></i>
            <div>
                <small class="text-muted d-block">Status Ketersediaan untuk tanggal:</small>
                <strong class="fs-5 text-dark"><?= date('d F Y', strtotime($tanggal_terpilih)) ?></strong>
            </div>
        </div>
    </div>
</section>

    <div class="main-content">
        <aside class="sidebar">
            <h3>Filter</h3>

            <form method="GET" action="<?= BASEURL ?>/peminjam/cek_ketersediaan" id="filter-form">
                <input type="hidden" name="tanggal" value="<?= htmlspecialchars($tanggal_terpilih) ?>">
                <input type="hidden" name="search" value="<?= htmlspecialchars($data['search'] ?? '') ?>">

                <div class="filter-section">
                    <h4>Lokasi</h4>
                    <label class="filter-item">
                        <input type="radio" name="lokasi" value="" <?= ($data['lokasi'] ?? '') === '' ? 'checked' : '' ?>> Semua Lokasi
                    </label>
                    <label class="filter-item">
                        <input type="radio" name="lokasi" value="lt1" <?= ($data['lokasi'] ?? '') === 'lt1' ? 'checked' : '' ?>> Lantai 1
                    </label>
                    <label class="filter-item">
                        <input type="radio" name="lokasi" value="lt2" <?= ($data['lokasi'] ?? '') === 'lt2' ? 'checked' : '' ?>> Lantai 2
                    </label>
                    <label class="filter-item">
                        <input type="radio" name="lokasi" value="lt3" <?= ($data['lokasi'] ?? '') === 'lt3' ? 'checked' : '' ?>> Lantai 3
                    </label>
                </div>

                <div class="filter-section">
                    <h4>Jenis Ruangan</h4>
                    <label class="filter-item">
                        <input type="radio" name="jenis" value="" <?= ($data['jenis'] ?? '') === '' ? 'checked' : '' ?>> Semua Jenis
                    </label>
                    <label class="filter-item">
                        <input type="radio" name="jenis" value="kelas" <?= ($data['jenis'] ?? '') === 'kelas' ? 'checked' : '' ?>> Kelas
                    </label>
                    <label class="filter-item">
                        <input type="radio" name="jenis" value="laboratorium" <?= ($data['jenis'] ?? '') === 'laboratorium' ? 'checked' : '' ?>> Laboratorium
                    </label>
                    <label class="filter-item">
                        <input type="radio" name="jenis" value="ruang rapat" <?= ($data['jenis'] ?? '') === 'ruang rapat' ? 'checked' : '' ?>> Ruang Rapat
                    </label>
                </div>
            </form>
        </aside>

        <div class="room-grid">
            <?php if (empty($data['ruangan'])): ?>
                <div class="no-data">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                    </svg>
                    <h3>Tidak ada ruangan ditemukan</h3>
                    <p>Coba gunakan filter atau kata kunci lain.</p>
                </div>
            <?php else: ?>
                <?php foreach ($data['ruangan'] as $room): ?>
                    <?php
                    $isBooked = $room['is_booked'] ?? false;
                    $canBook  = !$isBooked;
                    ?>
                    <div class="room-card <?= $canBook ? 'available' : 'unavailable' ?>">
                        <div class="room-header">
                            <h3><?= htmlspecialchars($room['nama_ruang']) ?></h3>
                            <span class="room-status <?= $canBook ? 'status-active' : 'status-inactive' ?>">
                                <?= $canBook ? 'Tersedia' : 'Penuh' ?>
                            </span>
                        </div>

                        <div class="room-info">
                            <p><strong>Lokasi:</strong> <?= htmlspecialchars($room['lokasi']) ?></p>
                            <p><strong>Kapasitas:</strong> <?= $room['kapasitas'] ?> orang</p>
                            <p><strong>Jenis:</strong> <?= htmlspecialchars($room['deskripsi']) ?></p>
                        </div>

                        <div class="room-action">
                            <?php if ($canBook): ?>
                                <a href="<?= BASEURL ?>/peminjam/form_peminjaman?ruang_id=<?= $room['ruang_id'] ?>&tanggal=<?= $tanggal_terpilih ?>"
                                   class="btn-pinjam">PILIH</a>
                            <?php else: ?>
                                <button class="btn-penuh" disabled>PENUH</button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-container">
            <p>&copy; 2025 MyRoom - Sistem Peminjaman Ruangan</p>
        </div>
    </footer>

    <script src="<?= BASEURL ?>/assets/js/cek_ruangan.js"></script>
</body>
</html>
