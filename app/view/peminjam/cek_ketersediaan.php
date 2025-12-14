<?php
session_start();

// ============================================
// KONEKSI DATABASE
// ============================================
try {
    $host = "localhost";
    $db_name = "db_sistem_peminjaman";
    $username = "root";
    $password = "";
    
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("set names utf8");
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// ============================================
// GET PARAMETER
// ============================================
$tanggal_cek = $_GET['tanggal'] ?? date('Y-m-d');
$lokasi_filter = $_GET['lokasi'] ?? '';
$search = trim($_GET['search'] ?? '');

// Mapping lokasi kode → teks tampilan
function formatLokasi($kode) {
    $map = [
        'lt1'     => 'Lantai 1',
        'lt2'     => 'Lantai 2',
        'lt3'     => 'Lantai 3',
        'lab_aud' => 'Laboratorium & Auditorium'
    ];
    return $map[$kode] ?? $kode;
}

// ============================================
// QUERY RUANGAN
// ============================================
try {
    $query = "SELECT * FROM ruang WHERE 1=1";
    $params = [];

    if ($lokasi_filter !== '') {
        $query .= " AND lokasi = :lokasi";
        $params[':lokasi'] = $lokasi_filter;
    }

    if ($search !== '') {
        $query .= " AND (nama_ruang LIKE :search OR lokasi LIKE :search OR deskripsi LIKE :search)";
        $params[':search'] = '%' . $search . '%';
    }

    $query .= " ORDER BY nama_ruang ASC";

    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    $ruangan = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Error fetching rooms: " . $e->getMessage());
}

// ============================================
// CEK KETERSEDIAAN RUANGAN
// ============================================
function cekKetersediaanRuangan($conn, $ruang_id, $tanggal) {
    try {
        $query = "SELECT COUNT(*) as total FROM peminjaman 
                  WHERE ruang_id = :ruang_id 
                  AND tanggal_mulai <= :tanggal 
                  AND tanggal_selesai >= :tanggal 
                  AND status IN ('pending', 'disetujui', 'konfirmasi_admin', 'konfirmasi_warek', 'diterima_admin')";
        $stmt = $conn->prepare($query);
        $stmt->execute([':ruang_id' => $ruang_id, ':tanggal' => $tanggal]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'] > 0;
    } catch(PDOException $e) {
        return false;
    }
}
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
                <a href="/peminjaman_ruang/app/view/peminjaman/cek_ketersediaan.php" class="nav-link active">Cek Ruang</a>
                <a href="/peminjaman_ruang/app/view/peminjaman/form_peminjaman.php" class="nav-link">Formulir Peminjaman</a>
            </div>
            <div class="nav-actions">
                <a href="/peminjaman_ruang/app/view/peminjaman/riwayat_peminjaman.php" class="nav-icon" title="Riwayat">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"></path><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"></path></svg>
                </a>
                <a href="/peminjaman_ruang/app/view/peminjaman/profile.php" class="nav-icon" title="Profile">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="8" r="3"></circle><path d="M6.168 18.849A4 4 0 0110 16h4a4 4 0 013.834 2.855"></path></svg>
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
                    <label for="search-ruang">Cek Ruangan</label>
                    <input type="text" id="search-ruang" name="search" placeholder="Cari nama ruangan..." value="<?= htmlspecialchars($search) ?>">
                </div>
                <div class="form-group">
                    <label for="tanggal-cek">Tanggal</label>
                    <input type="date" id="tanggal-cek" name="tanggal" value="<?= $tanggal_cek ?>" min="<?= date('Y-m-d') ?>">
                </div>
                <button type="submit" class="btn-cek">Cek</button>
            </form>
            <div class="status-info">
                <p>Status untuk tanggal: <strong><?= date('d F Y', strtotime($tanggal_cek)) ?></strong></p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Sidebar Filter -->
        <aside class="sidebar">
            <h3>Filter</h3>
            <div class="filter-section">
                <h4>Lokasi</h4>
                <form method="GET" action="" id="filter-form">
                    <input type="hidden" name="tanggal" value="<?= $tanggal_cek ?>">
                    <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">

                    <label class="filter-item">
                        <input type="radio" name="lokasi" value="" <?= $lokasi_filter === '' ? 'checked' : '' ?>>
                        <span>Semua Ruangan</span>
                    </label>
                    <label class="filter-item">
                        <input type="radio" name="lokasi" value="lt1" <?= $lokasi_filter === 'lt1' ? 'checked' : '' ?>>
                        <span>Lantai 1</span>
                    </label>
                    <label class="filter-item">
                        <input type="radio" name="lokasi" value="lt2" <?= $lokasi_filter === 'lt2' ? 'checked' : '' ?>>
                        <span>Lantai 2</span>
                    </label>
                    <label class="filter-item">
                        <input type="radio" name="lokasi" value="lt3" <?= $lokasi_filter === 'lt3' ? 'checked' : '' ?>>
                        <span>Lantai 3</span>
                    </label>
                    <label class="filter-item">
                        <input type="radio" name="lokasi" value="lab_aud" <?= $lokasi_filter === 'lab_aud' ? 'checked' : '' ?>>
                        <span>Laboratorium & Auditorium</span>
                    </label>
                </form>
            </div>
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
                <?php foreach ($ruangan as $room):
                    $is_booked = cekKetersediaanRuangan($conn, $room['ruang_id'], $tanggal_cek);
                    $is_active = strtolower($room['status']) === 'aktif';
                    $can_book = $is_active && !$is_booked;
                ?>
                    <div class="room-card <?= $can_book ? 'available' : 'unavailable' ?>">
                        <div class="room-header">
                            <h3><?= htmlspecialchars($room['nama_ruang']) ?></h3>
                            <span class="room-status <?= $is_active ? 'status-active' : 'status-inactive' ?>">
                                <?= $is_active ? 'Aktif' : 'Non-aktif' ?>
                            </span>
                        </div>
                        <div class="room-info">
                            <p><strong>Lokasi:</strong> <?= formatLokasi($room['lokasi']) ?></p>
                            <p><strong>Kapasitas:</strong> <?= htmlspecialchars($room['kapasitas']) ?> orang</p>
                            <p><strong>Deskripsi:</strong> <?= htmlspecialchars($room['deskripsi']) ?></p>
                        </div>
                        <div class="room-action">
                            <?php if ($can_book): ?>
                                <a href="/peminjaman_ruang/app/view/peminjaman/form_peminjaman.php?ruang_id=<?= $room['ruang_id'] ?>&tanggal=<?= $tanggal_cek ?>"
                                   class="btn-pinjam">Pilih</a>
                            <?php else: ?>
                                <button class="btn-penuh" disabled>
                                    <?= $is_booked ? 'Penuh' : 'Non-aktif' ?>
                                </button>
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
            <p>&copy; 2024 MyRoom - Sistem Peminjaman Ruangan. All rights reserved.</p>
        </div>
    </footer>

    <script src="/peminjaman_ruang/public/assets/js/cek_ruangan.js"></script>
</body>
</html>