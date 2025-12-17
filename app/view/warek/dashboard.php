<?php

$namaWarek     = $data['namaWarek'] ?? 'Warek';
$pendingCount  = $data['pendingCount'] ?? 0;
$approvedCount = $data['approvedCount'] ?? 0;
$totalCount    = $data['totalCount'] ?? 0;
$historyData   = $data['historyData'] ?? [];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Warek - MyRoom</title>
    <link rel="stylesheet" href="<?= BASEURL; ?>/assets/css/warek_dashboard.css">
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
                <li><a href="dashboard.php" class="nav-link active">Home</a></li>
            </ul>
            <div class="nav-right">
                <div class="profile-dropdown">
                    <button class="profile-btn" id="profileBtn">
                        <i class="fas fa-user-circle"></i>
                        <span>Profil</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu" id="dropdownMenu">
                        <a href="profile.php" class="dropdown-item">
                            <i class="fas fa-user"></i>
                            <span>Lihat Profil</span>
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

    <!-- Hero Section -->
    <section class="hero-dashboard">
        <div class="hero-pattern"></div>
        <div class="container">
            <div class="welcome-card">
                <div class="welcome-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="welcome-content">
                    <h1 class="welcome-title">Selamat Datang, <?php echo htmlspecialchars($namaWarek); ?></h1>
                    <div class="welcome-badge">
                        <i class="fas fa-crown"></i>
                        <span>Wakil Rektor</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="main-content">
        <div class="container">
            <!-- Dashboard Description -->
            <div class="dashboard-info">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="info-content">
                        <h2 class="info-title">Tentang Dashboard Warek</h2>
                        <p class="info-description">
                            Dashboard Warek merupakan halaman utama yang digunakan oleh Wakil Rektor sebagai pihak
                            otoritas tertinggi dalam proses persetujuan peminjaman ruangan. Pada halaman ini, Warek
                            dapat melihat ringkasan informasi serta melakukan tindakan konfirmasi akhir terhadap
                            seluruh permohonan peminjaman yang telah disetujui oleh admin sebelumnya.
                        </p>
                        <p class="info-description">
                            Melalui dashboard ini, Warek dapat memastikan bahwa setiap peminjaman ruangan berjalan
                            sesuai prosedur, serta memberikan keputusan akhir melalui fitur konfirmasi yang tersedia.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon pending">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number" data-target="<?php echo $pendingCount; ?>">0</h3>
                        <p class="stat-label">Menunggu Konfirmasi</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon approved">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number" data-target="<?php echo $approvedCount; ?>">0</h3>
                        <p class="stat-label">Telah Dikonfirmasi</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon total">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number" data-target="<?php echo $totalCount; ?>">0</h3>
                        <p class="stat-label">Total Pengajuan</p>
                    </div>
                </div>
            </div>

            <!-- Main Action Button -->
            <div class="action-section">
                <div class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <h2 class="action-title">Konfirmasi Peminjaman Ruangan</h2>
                    <p class="action-description">
                        Tinjau dan berikan konfirmasi akhir untuk peminjaman ruangan yang telah disetujui oleh admin
                    </p>
                    <a href="<?= BASEURL ?>/warek/konfirmasi" class="btn btn-primary">
                        <i class="fas fa-arrow-right"></i>
                        Konfirmasi Peminjaman
                    </a>
                </div>
            </div>

            <!-- Riwayat Konfirmasi -->
            <div class="recent-activity">
                <h2 class="section-title">Riwayat Konfirmasi</h2>
                <div class="history-table-container">
                    <?php if (count($historyData) > 0): ?>
                        <table class="history-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Ruangan</th>
                                    <th>Peminjam</th>
                                    <th>Tanggal Peminjaman</th>
                                    <th>Keperluan</th>
                                    <th>Status</th>
                                    <th>Alasan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($historyData as $row):
                                    // Format status
                                    $statusClass = '';
                                    $statusText = '';
                                    $alasan = '';

                                    if ($row['status'] == 'konfirmasi_warek') {
                                        $statusClass = 'approved';
                                        $statusText = 'Disetujui Warek';
                                        $alasan = $row['alasan_warek'] ?? '';
                                    } elseif ($row['status'] == 'ditolak_admin') {
                                        $statusClass = 'rejected';
                                        $statusText = 'Ditolak Admin';
                                        $alasan = $row['alasan_penolakan_admin'] ?? '';
                                    } elseif ($row['status'] == 'diterima_admin') {
                                        $statusClass = 'approved';
                                        $statusText = 'Disetujui Admin';
                                        $alasan = '';
                                    }

                                    // Format tanggal Indonesia
                                    $bulan = [
                                        1 => 'Jan',
                                        2 => 'Feb',
                                        3 => 'Mar',
                                        4 => 'Apr',
                                        5 => 'Mei',
                                        6 => 'Jun',
                                        7 => 'Jul',
                                        8 => 'Agu',
                                        9 => 'Sep',
                                        10 => 'Okt',
                                        11 => 'Nov',
                                        12 => 'Des'
                                    ];

                                    $tglMulai = date('d', strtotime($row['tanggal_mulai'])) . ' ' .
                                        $bulan[date('n', strtotime($row['tanggal_mulai']))] . ' ' .
                                        date('Y', strtotime($row['tanggal_mulai']));

                                    $tglSelesai = date('d', strtotime($row['tanggal_selesai'])) . ' ' .
                                        $bulan[date('n', strtotime($row['tanggal_selesai']))] . ' ' .
                                        date('Y', strtotime($row['tanggal_selesai']));

                                    $tanggal = $tglMulai . ' - ' . $tglSelesai;
                                ?>
                                    <tr>
                                        <td class="table-number"><?php echo $no++; ?></td>
                                        <td>
                                            <div class="ruang-name"><?php echo htmlspecialchars($row['nama_ruang']); ?></div>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['peminjam_nama']); ?></td>
                                        <td>
                                            <div class="date-range"><?php echo $tanggal; ?></div>
                                        </td>
                                        <td>
                                            <div class="keperluan-text" title="<?php echo htmlspecialchars($row['keperluan']); ?>">
                                                <?php echo htmlspecialchars($row['keperluan']); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="status-badge <?php echo $statusClass; ?>">
                                                <i class="fas fa-<?php echo $statusClass == 'approved' ? 'check-circle' : 'times-circle'; ?>"></i>
                                                <?php echo $statusText; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php
                                            if (!empty($alasan)) {
                                                echo '<div class="alasan-text" title="' . htmlspecialchars($alasan) . '">';
                                                echo htmlspecialchars($alasan);
                                                echo '</div>';
                                            } else {
                                                echo '<span style="color: #999;">-</span>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a href="detail_peminjaman.php?id=<?php echo $row['peminjaman_id']; ?>" class="view-details-btn">
                                                <i class="fas fa-eye"></i>
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="no-data">
                            <i class="fas fa-inbox"></i>
                            <p>Belum ada riwayat konfirmasi</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

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

    <script src="../../../public/assets/js/warek_dashboard.js"></script>
</body>

</html>