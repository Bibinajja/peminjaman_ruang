<?php
session_start();

// Check if user is logged in and has Warek role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'warek') {
    header('Location: ../../../index.php');
    exit();
}

// Database connection using existing Database class
require_once '../../core/Database.php';
$db = new Database();

// Fetch pending peminjaman (status = 'konfirmasi_admin')
$query = "SELECT 
            p.peminjaman_id,
            p.user_id,
            p.ruang_id,
            p.tanggal_mulai,
            p.tanggal_selesai,
            p.keperluan,
            p.status,
            p.created_at,
            u.nama as nama_peminjam,
            u.email as email_peminjam,
            r.nama_ruang,
            r.kapasitas,
            r.lokasi
          FROM peminjaman p
          JOIN users u ON p.user_id = u.user_id
          JOIN ruang r ON p.ruang_id = r.ruang_id
          WHERE p.status = :status
          ORDER BY p.created_at DESC";

$db->query($query);
$db->bind(':status', 'konfirmasi_admin');
$peminjaman_list = $db->resultSet();

// Count pending bookings
$pending_count = count($peminjaman_list);

// Get user info
$user_name = $_SESSION['nama'] ?? 'Wakil Rektor';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Peminjaman - Warek MyRoom</title>
    <link rel="stylesheet" href="../../../public/assets/css/warek_peminjaman.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <div class="nav-brand">
                <h2 class="logo">MyRoom</h2>
            </div>
            <ul class="nav-menu" id="navMenu">
                <li><a href="dashboard.php" class="nav-link">Home</a></li>
            </ul>

            <div class="nav-right">
                <div class="profile-dropdown">
                    <button class="profile-btn" id="profileBtn">
                        <i class="fas fa-user-circle"></i>
                        <span><?php echo htmlspecialchars($user_name); ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu" id="dropdownMenu">
                        <a href="profile.php" class="dropdown-item">
                            <i class="fas fa-user"></i>
                            <span>Lihat Profil</span>
                        </a>
                        <a href="settings.php" class="dropdown-item">
                            <i class="fas fa-cog"></i>
                            <span>Pengaturan</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="../../../index.php" class="dropdown-item logout">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Keluar</span>
                        </a>
                    </div>
                </div>
                <div class="hamburger" id="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="header-content">
                <div class="header-icon">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <div class="header-text">
                    <h1 class="page-title">Konfirmasi Wakil Rektor</h1>
                    <p class="page-subtitle">Kelola dan konfirmasi peminjaman ruangan yang telah disetujui admin</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="main-content">
        <div class="container">

            <!-- Filter & Search -->
            <div class="filter-section">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Cari peminjaman...">
                </div>
                <div class="filter-buttons">
                    <button class="filter-btn active" data-filter="all">
                        <i class="fas fa-list"></i> Semua
                    </button>
                    <button class="filter-btn" data-filter="pending">
                        <i class="fas fa-clock"></i> Menunggu
                    </button>
                    <button class="filter-btn" data-filter="urgent">
                        <i class="fas fa-exclamation-circle"></i> Mendesak
                    </button>
                </div>
            </div>

            <!-- Peminjaman List -->
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-door-open"></i>
                    Daftar Peminjaman Ruang
                </h2>
                <span class="badge-count"><?php echo $pending_count; ?> Peminjaman Menunggu</span>
            </div>

            <div class="peminjaman-grid">
                <?php if (empty($peminjaman_list)): ?>
                    <div class="empty-state" style="grid-column: 1/-1; text-align: center; padding: 3rem;">
                        <i class="fas fa-inbox" style="font-size: 4rem; color: #93A99A; margin-bottom: 1rem;"></i>
                        <h3 style="color: #3B6EA5; margin-bottom: 0.5rem;">Tidak Ada Peminjaman</h3>
                        <p style="color: #93A99A;">Belum ada peminjaman yang menunggu konfirmasi Anda</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($peminjaman_list as $index => $peminjaman):
                        // Determine if booking is urgent (within 2 days)
                        $tanggal_mulai = strtotime($peminjaman['tanggal_mulai']);
                        $today = time();
                        $diff_days = floor(($tanggal_mulai - $today) / (60 * 60 * 24));
                        $is_urgent = $diff_days <= 2;

                        // Format dates for Indonesian locale
                        $months = [
                            1 => 'Januari',
                            2 => 'Februari',
                            3 => 'Maret',
                            4 => 'April',
                            5 => 'Mei',
                            6 => 'Juni',
                            7 => 'Juli',
                            8 => 'Agustus',
                            9 => 'September',
                            10 => 'Oktober',
                            11 => 'November',
                            12 => 'Desember'
                        ];

                        $start_time = strtotime($peminjaman['tanggal_mulai']);
                        $end_time = strtotime($peminjaman['tanggal_selesai']);

                        $formatted_start = date('d', $start_time) . ' ' .
                            $months[date('n', $start_time)] . ' ' .
                            date('Y - H:i', $start_time);
                        $formatted_end = date('d', $end_time) . ' ' .
                            $months[date('n', $end_time)] . ' ' .
                            date('Y - H:i', $end_time);
                    ?>
                        <div class="peminjaman-card" data-id="<?php echo $peminjaman['peminjaman_id']; ?>">
                            <div class="card-header">
                                <div class="card-id">
                                    <i class="fas fa-hashtag"></i>
                                    <span>PM<?php echo str_pad($peminjaman['peminjaman_id'], 3, '0', STR_PAD_LEFT); ?></span>
                                </div>
                                <span class="badge <?php echo $is_urgent ? 'badge-urgent' : 'badge-pending'; ?>">
                                    <?php echo $is_urgent ? 'Mendesak' : 'Menunggu'; ?>
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="info-item">
                                    <i class="fas fa-user"></i>
                                    <div class="info-content">
                                        <span class="info-label">Nama Peminjam</span>
                                        <span class="info-value"><?php echo htmlspecialchars($peminjaman['nama_peminjam']); ?></span>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-door-closed"></i>
                                    <div class="info-content">
                                        <span class="info-label">Ruangan</span>
                                        <span class="info-value"><?php echo htmlspecialchars($peminjaman['nama_ruang']); ?></span>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-calendar-start"></i>
                                    <div class="info-content">
                                        <span class="info-label">Tanggal Mulai</span>
                                        <span class="info-value"><?php echo $formatted_start; ?></span>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-calendar-check"></i>
                                    <div class="info-content">
                                        <span class="info-label">Tanggal Selesai</span>
                                        <span class="info-value"><?php echo $formatted_end; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-detail" onclick="showDetail(<?php echo $peminjaman['peminjaman_id']; ?>)">
                                    <i class="fas fa-info-circle"></i>
                                    Detail
                                </button>
                                <button class="btn btn-approve" onclick="approveBooking(<?php echo $peminjaman['peminjaman_id']; ?>)">
                                    <i class="fas fa-check"></i>
                                    Setuju
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Detail Modal -->
    <div class="modal" id="detailModal">
        <div class="modal-overlay" onclick="closeModal()"></div>
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">
                    <i class="fas fa-file-alt"></i>
                    Detail Peminjaman
                </h2>
                <button class="modal-close" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="detail-grid">
                    <div class="detail-item">
                        <i class="fas fa-hashtag"></i>
                        <div class="detail-content">
                            <span class="detail-label">ID Peminjaman</span>
                            <span class="detail-value" id="detailID">-</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-user"></i>
                        <div class="detail-content">
                            <span class="detail-label">Nama Peminjam</span>
                            <span class="detail-value" id="detailUser">-</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-envelope"></i>
                        <div class="detail-content">
                            <span class="detail-label">Email Peminjam</span>
                            <span class="detail-value" id="detailEmail">-</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-door-closed"></i>
                        <div class="detail-content">
                            <span class="detail-label">Ruangan</span>
                            <span class="detail-value" id="detailRoom">-</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div class="detail-content">
                            <span class="detail-label">Lokasi</span>
                            <span class="detail-value" id="detailLocation">-</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-users"></i>
                        <div class="detail-content">
                            <span class="detail-label">Kapasitas Ruangan</span>
                            <span class="detail-value" id="detailCapacity">-</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-calendar-start"></i>
                        <div class="detail-content">
                            <span class="detail-label">Tanggal Mulai</span>
                            <span class="detail-value" id="detailStart">-</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-calendar-check"></i>
                        <div class="detail-content">
                            <span class="detail-label">Tanggal Selesai</span>
                            <span class="detail-value" id="detailEnd">-</span>
                        </div>
                    </div>
                    <div class="detail-item detail-full">
                        <i class="fas fa-clipboard"></i>
                        <div class="detail-content">
                            <span class="detail-label">Keperluan</span>
                            <span class="detail-value" id="detailPurpose">-</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-approve" onclick="approveFromModal()">
                    <i class="fas fa-check"></i>
                    Setujui Peminjaman
                </button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h3>MyRoom</h3>
                    <p>Sistem Peminjaman Ruang ITS Mandala</p>
                </div>
                <div class="footer-col">
                    <h4>Kontak</h4>
                    <ul>
                        <li><i class="fas fa-envelope"></i> info@itsmandala.ac.id</li>
                        <li><i class="fas fa-phone"></i> +62 831-2931-3931</li>
                        <li><i class="fas fa-clock"></i> Senin - Jumat (07.00 - 16.00 WIB)</li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Lokasi</h4>
                    <ul>
                        <li><i class="fas fa-map-marker-alt"></i> Jember, Jawa Timur</li>
                        <li><a href="https://maps.app.goo.gl/1Bk6QgeT31Cdvtzu7" target="_blank"><i class="fas fa-map"></i> Lihat Peta</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Sosial Media</h4>
                    <div class="social-links">
                        <a href="https://www.instagram.com/itsmandala.official" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://wa.me/6283129313931" target="_blank">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 MyRoom - ITS Mandala. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Pass PHP data to JavaScript -->
    <script>
        const peminjamanData = <?php echo json_encode($peminjaman_list); ?>;
    </script>
    <script src="../../../public/assets/js/warek_peminjaman.js"></script>
</body>

</html>