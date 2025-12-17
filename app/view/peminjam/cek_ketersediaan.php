<?php

$tanggal = $data['tanggal'] ?? date('Y-m-d');
$lokasi  = $data['lokasi']  ?? '';
$jenis   = $data['jenis']   ?? '';
$search  = $data['search']  ?? '';

// // Query ruangan
// try {
//     $query = "SELECT * FROM ruang WHERE 1=1";

//     // Filter lokasi (lt1, lt2, lt3)
//     if ($lokasi_filter !== '') {
//         $query .= " AND lokasi = :lokasi";
//     }

//     // Filter jenis ruang (kelas, laboratorium, ruang rapat)
//     if ($jenis_filter !== '') {
//         $query .= " AND deskripsi = :jenis";
//     }

//     // Search bebas
//     if ($search !== '') {
//         $query .= " AND nama_ruang LIKE :search";
//     }

//     $query .= " ORDER BY nama_ruang ASC";

//     $db->query($query);

//     if ($lokasi_filter !== '') {
//         $db->bind(':lokasi', $lokasi_filter);
//     }

//     if ($jenis_filter !== '') {
//         $db->bind(':jenis', $jenis_filter);
//     }

//     if ($search !== '') {
//         $db->bind(':search', '%' . $search . '%');
//     }

//     $ruangan = $db->resultSet();
// } catch (Exception $e) {
//     die("Error: " . $e->getMessage());
// }



?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyRoom - Cek Ketersediaan Ruangan</title>
    <link rel="stylesheet" href="/peminjaman_ruang/public/assets/css/cek_ruangan.css">
</head>

<body>

    <!-- Navbar -->
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
                <a href="<?= BASEURL ?>/peminjam/riwayat_peminjaman" class="nav-icon" title="Riwayat">
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

    <!-- Search Section -->
    <section class="search-section">
        <div class="search-container">
            <h1>Cek Ketersediaan Ruangan</h1>
            <form method="GET" action="" class="search-form">
                <div class="form-group">
                    <label for="search-ruang">Cari Ruangan</label>
                    <input type="text" id="search-ruang" name="search" placeholder="Cari nama ruangan..." value="<?= htmlspecialchars($data['search'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="tanggal-cek">Tanggal</label>
                    <input type="date" name="tanggal"
                        value="<?= $tanggal ?>"
                        min="<?= date('Y-m-d') ?>">

                </div>
                <button type="submit" class="btn-cek">Cek</button>
            </form>
            <div class="status-info">
                <p>Status untuk tanggal: <strong class="tanggal-cek">
                        <?= date('d F Y', strtotime($tanggal)) ?>
                    </strong></p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Sidebar Filter -->
        <aside class="sidebar">
            <h3>Filter</h3>

            <form method="GET" action="" id="filter-form">

                <input type="hidden" name="tanggal" value="<?= $tanggal ?>">
                <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">

                <!-- FILTER LOKASI -->
                <div class="filter-section">
                    <h4>Lokasi</h4>

                    <label>
                        <input type="radio" name="lokasi" value="" <?= $lokasi === '' ? 'checked' : '' ?>>
                        Semua Lokasi
                    </label>

                    <label>
                        <input type="radio" name="lokasi" value="lt1" <?= $lokasi === 'lt1' ? 'checked' : '' ?>>
                        Lantai 1
                    </label>

                    <label>
                        <input type="radio" name="lokasi" value="lt2" <?= $lokasi === 'lt2' ? 'checked' : '' ?>>
                        Lantai 2
                    </label>

                    <label>
                        <input type="radio" name="lokasi" value="lt3" <?= $lokasi === 'lt3' ? 'checked' : '' ?>>
                        Lantai 3
                    </label>

                    <!-- FILTER JENIS -->
                    <label>
                        <input type="radio" name="jenis" value="" <?= $jenis === '' ? 'checked' : '' ?>>
                        Semua Jenis
                    </label>

                    <label>
                        <input type="radio" name="jenis" value="kelas" <?= $jenis === 'kelas' ? 'checked' : '' ?>>
                        Kelas
                    </label>

                    <label>
                        <input type="radio" name="jenis" value="laboratorium" <?= $jenis === 'laboratorium' ? 'checked' : '' ?>>
                        Laboratorium
                    </label>

                    <label>
                        <input type="radio" name="jenis" value="ruang rapat" <?= $jenis === 'ruang rapat' ? 'checked' : '' ?>>
                        Ruang Rapat
                    </label>
                </div>

            </form>
        </aside>


        <!-- Room Grid -->
        <div class="room-grid">
            <?php if (empty($ruangan)): ?>
                <div class="no-data">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                    </svg>
                    <h3>Tidak ada ruangan yang ditemukan</h3>
                    <p>Coba ubah filter atau kata kunci pencarian Anda</p>
                </div>
            <?php else: ?>
                <?php foreach ($data['ruangan'] as $room): ?>
                    <?php
                    $isBooked = $room['is_booked']; // dari model
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
                                <a href="<?= BASEURL ?>/peminjam/form_peminjaman?ruang_id=<?= $room['ruang_id'] ?>&tanggal=<?= $tanggal ?>"
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

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <p>&copy; 2025 MyRoom - Sistem Peminjaman Ruangan</p>
        </div>
    </footer>

    <script src="/peminjaman_ruang/public/assets/js/cek_ruangan.js"></script>
</body>

</html>