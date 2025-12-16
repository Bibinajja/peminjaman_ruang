<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Warek - MyRoom</title>
    <link rel="stylesheet" href="../../../public/assets/css/warek_dashboard.css">
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
                <li><a href="peminjaman.php" class="nav-link">Peminjaman</a></li>
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

    <!-- Hero Section -->
    <section class="hero-dashboard">
        <div class="hero-pattern"></div>
        <div class="container">
            <div class="welcome-card">
                <div class="welcome-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="welcome-content">
                    <h1 class="welcome-title">Selamat Datang Warek</h1>
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
                        <h3 class="stat-number">12</h3>
                        <p class="stat-label">Menunggu Konfirmasi</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon approved">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">48</h3>
                        <p class="stat-label">Telah Dikonfirmasi</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon total">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">65</h3>
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
                    <a href="konfirmasi_warek.php" class="btn btn-primary">
                        <i class="fas fa-arrow-right"></i>
                        Konfirmasi Peminjaman
                    </a>
                </div>
            </div>

            <!-- Quick Access -->
            <div class="quick-access">
                <h2 class="section-title">Akses Cepat</h2>
                <div class="quick-grid">
                    <a href="peminjaman.php" class="quick-card">
                        <div class="quick-icon">
                            <i class="fas fa-list-check"></i>
                        </div>
                        <h3 class="quick-title">Daftar Peminjaman</h3>
                        <p class="quick-desc">Lihat semua pengajuan peminjaman ruangan</p>
                    </a>
                    <a href="history.php" class="quick-card">
                        <div class="quick-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <h3 class="quick-title">Riwayat</h3>
                        <p class="quick-desc">Lihat riwayat konfirmasi peminjaman</p>
                    </a>
                    <a href="reports.php" class="quick-card">
                        <div class="quick-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <h3 class="quick-title">Laporan</h3>
                        <p class="quick-desc">Lihat laporan dan statistik peminjaman</p>
                    </a>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="recent-activity">
                <h2 class="section-title">Aktivitas Terbaru</h2>
                <div class="activity-card">
                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="activity-icon approved">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="activity-content">
                                <h4 class="activity-title">Peminjaman Disetujui</h4>
                                <p class="activity-desc">Ruang Seminar A - 15 Desember 2024</p>
                                <span class="activity-time">2 jam yang lalu</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon pending">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="activity-content">
                                <h4 class="activity-title">Menunggu Konfirmasi</h4>
                                <p class="activity-desc">Lab Komputer 1 - 18 Desember 2024</p>
                                <span class="activity-time">5 jam yang lalu</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon rejected">
                                <i class="fas fa-times"></i>
                            </div>
                            <div class="activity-content">
                                <h4 class="activity-title">Peminjaman Ditolak</h4>
                                <p class="activity-desc">Aula Utama - 20 Desember 2024</p>
                                <span class="activity-time">1 hari yang lalu</span>
                            </div>
                        </div>
                    </div>
                    <a href="history.php" class="view-all-link">
                        Lihat Semua Aktivitas <i class="fas fa-arrow-right"></i>
                    </a>
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