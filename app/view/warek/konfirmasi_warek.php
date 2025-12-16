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
                <li><a href="peminjaman.php" class="nav-link active">Peminjaman</a></li>
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
                <span class="badge-count">12 Peminjaman Menunggu</span>
            </div>

            <div class="peminjaman-grid">

                <!-- Card 1 -->
                <div class="peminjaman-card" data-id="PM001">
                    <div class="card-header">
                        <div class="card-id">
                            <i class="fas fa-hashtag"></i>
                            <span>PM001</span>
                        </div>
                        <span class="badge badge-pending">Menunggu</span>
                    </div>
                    <div class="card-body">
                        <div class="info-item">
                            <i class="fas fa-user"></i>
                            <div class="info-content">
                                <span class="info-label">Nama Peminjam</span>
                                <span class="info-value">Ahmad Fauzi</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-door-closed"></i>
                            <div class="info-content">
                                <span class="info-label">Ruangan</span>
                                <span class="info-value">Ruang Seminar A</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-calendar-start"></i>
                            <div class="info-content">
                                <span class="info-label">Tanggal Mulai</span>
                                <span class="info-value">15 Desember 2024 - 08:00</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-calendar-check"></i>
                            <div class="info-content">
                                <span class="info-label">Tanggal Selesai</span>
                                <span class="info-value">15 Desember 2024 - 12:00</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-detail" onclick="showDetail('PM001')">
                            <i class="fas fa-info-circle"></i>
                            Detail
                        </button>
                        <button class="btn btn-approve" onclick="approveBooking('PM001')">
                            <i class="fas fa-check"></i>
                            Setuju
                        </button>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="peminjaman-card" data-id="PM002">
                    <div class="card-header">
                        <div class="card-id">
                            <i class="fas fa-hashtag"></i>
                            <span>PM002</span>
                        </div>
                        <span class="badge badge-urgent">Mendesak</span>
                    </div>
                    <div class="card-body">
                        <div class="info-item">
                            <i class="fas fa-user"></i>
                            <div class="info-content">
                                <span class="info-label">Nama Peminjam</span>
                                <span class="info-value">Siti Nurhaliza</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-door-closed"></i>
                            <div class="info-content">
                                <span class="info-label">Ruangan</span>
                                <span class="info-value">Lab Komputer 1</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-calendar-start"></i>
                            <div class="info-content">
                                <span class="info-label">Tanggal Mulai</span>
                                <span class="info-value">14 Desember 2024 - 13:00</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-calendar-check"></i>
                            <div class="info-content">
                                <span class="info-label">Tanggal Selesai</span>
                                <span class="info-value">14 Desember 2024 - 16:00</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-detail" onclick="showDetail('PM002')">
                            <i class="fas fa-info-circle"></i>
                            Detail
                        </button>
                        <button class="btn btn-approve" onclick="approveBooking('PM002')">
                            <i class="fas fa-check"></i>
                            Setuju
                        </button>
                        <button class="btn btn-reject" onclick="rejectBooking('PM002')">
                            <i class="fas fa-times"></i>
                            Tolak
                        </button>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="peminjaman-card" data-id="PM003">
                    <div class="card-header">
                        <div class="card-id">
                            <i class="fas fa-hashtag"></i>
                            <span>PM003</span>
                        </div>
                        <span class="badge badge-pending">Menunggu</span>
                    </div>
                    <div class="card-body">
                        <div class="info-item">
                            <i class="fas fa-user"></i>
                            <div class="info-content">
                                <span class="info-label">Nama Peminjam</span>
                                <span class="info-value">Budi Santoso</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-door-closed"></i>
                            <div class="info-content">
                                <span class="info-label">Ruangan</span>
                                <span class="info-value">Aula Utama</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-calendar-start"></i>
                            <div class="info-content">
                                <span class="info-label">Tanggal Mulai</span>
                                <span class="info-value">20 Desember 2024 - 09:00</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-calendar-check"></i>
                            <div class="info-content">
                                <span class="info-label">Tanggal Selesai</span>
                                <span class="info-value">20 Desember 2024 - 15:00</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-detail" onclick="showDetail('PM003')">
                            <i class="fas fa-info-circle"></i>
                            Detail
                        </button>
                        <button class="btn btn-approve" onclick="approveBooking('PM003')">
                            <i class="fas fa-check"></i>
                            Setuju
                        </button>
                        <button class="btn btn-reject" onclick="rejectBooking('PM003')">
                            <i class="fas fa-times"></i>
                            Tolak
                        </button>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="peminjaman-card" data-id="PM004">
                    <div class="card-header">
                        <div class="card-id">
                            <i class="fas fa-hashtag"></i>
                            <span>PM004</span>
                        </div>
                        <span class="badge badge-pending">Menunggu</span>
                    </div>
                    <div class="card-body">
                        <div class="info-item">
                            <i class="fas fa-user"></i>
                            <div class="info-content">
                                <span class="info-label">Nama Peminjam</span>
                                <span class="info-value">Dewi Lestari</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-door-closed"></i>
                            <div class="info-content">
                                <span class="info-label">Ruangan</span>
                                <span class="info-value">Ruang Rapat B</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-calendar-start"></i>
                            <div class="info-content">
                                <span class="info-label">Tanggal Mulai</span>
                                <span class="info-value">18 Desember 2024 - 10:00</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-calendar-check"></i>
                            <div class="info-content">
                                <span class="info-label">Tanggal Selesai</span>
                                <span class="info-value">18 Desember 2024 - 14:00</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-detail" onclick="showDetail('PM004')">
                            <i class="fas fa-info-circle"></i>
                            Detail
                        </button>
                        <button class="btn btn-approve" onclick="approveBooking('PM004')">
                            <i class="fas fa-check"></i>
                            Setuju
                        </button>
                        <button class="btn btn-reject" onclick="rejectBooking('PM004')">
                            <i class="fas fa-times"></i>
                            Tolak
                        </button>
                    </div>
                </div>

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
                            <span class="detail-value" id="detailID">PM001</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-user"></i>
                        <div class="detail-content">
                            <span class="detail-label">Nama User</span>
                            <span class="detail-value" id="detailUser">Ahmad Fauzi</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-door-closed"></i>
                        <div class="detail-content">
                            <span class="detail-label">Ruangan</span>
                            <span class="detail-value" id="detailRoom">Ruang Seminar A</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-calendar-start"></i>
                        <div class="detail-content">
                            <span class="detail-label">Tanggal Mulai</span>
                            <span class="detail-value" id="detailStart">15 Desember 2024 - 08:00</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-calendar-check"></i>
                        <div class="detail-content">
                            <span class="detail-label">Tanggal Selesai</span>
                            <span class="detail-value" id="detailEnd">15 Desember 2024 - 12:00</span>
                        </div>
                    </div>
                    <div class="detail-item detail-full">
                        <i class="fas fa-clipboard"></i>
                        <div class="detail-content">
                            <span class="detail-label">Keperluan</span>
                            <span class="detail-value" id="detailPurpose">
                                Seminar nasional tentang teknologi informasi dan digitalisasi pendidikan tinggi.
                                Acara ini akan dihadiri oleh 150 peserta dari berbagai universitas di Indonesia.
                                Kegiatan meliputi presentasi, diskusi panel, dan networking session.
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-approve" onclick="approveFromModal()">
                    <i class="fas fa-check"></i>
                    Setujui Peminjaman
                </button>
                <button class="btn btn-reject" onclick="rejectFromModal()">
                    <i class="fas fa-times"></i>
                    Tolak Peminjaman
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

    <script src="../../../public/assets/js/warek_peminjaman.js"></script>
</body>

</html>