<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - MyRoom</title>

    <link rel="stylesheet" href="<?= BASEURL ?>/assets/css/warek_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

    <!-- ================= NAVBAR ================= -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <div class="nav-brand">
                <h2 class="logo">MyRoom</h2>
            </div>

            <ul class="nav-menu" id="navMenu">
                <li><a href="<?= BASEURL ?>/admin" class="nav-link active">Dashboard</a></li>
                <li><a href="<?= BASEURL ?>/admin/ruang" class="nav-link">Ruang</a></li>
                <li><a href="<?= BASEURL ?>/admin/user" class="nav-link">User</a></li>
            </ul>

            <div class="nav-right">
                <div class="profile-dropdown">
                    <button class="profile-btn" id="profileBtn">
                        <i class="fas fa-user-shield"></i>
                        <span>Admin</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>

                    <div class="dropdown-menu" id="dropdownMenu">
                        <a href="<?= BASEURL ?>/user/profil" class="dropdown-item">
                            <i class="fas fa-user"></i> Profil
                        </a>

                        <div class="dropdown-divider"></div>
                        <a href="<?= BASEURL ?>/home/index" class="dropdown-item logout">
                            <i class="fas fa-sign-out-alt"></i> Keluar
                        </a>
                    </div>
                </div>

                <div class="hamburger" id="hamburger">
                    <span></span><span></span><span></span>
                </div>
            </div>
        </div>
    </nav>

    <!-- ================= HERO ================= -->
    <section class="hero-dashboard">
        <div class="hero-pattern"></div>
        <div class="container">
            <div class="welcome-card">
                <div class="welcome-icon">
                    <i class="fas fa-user-cog"></i>
                </div>
                <div class="welcome-content">
                    <h1 class="welcome-title">Selamat Datang Admin</h1>
                    <div class="welcome-badge">
                        <i class="fas fa-shield-alt"></i>
                        <span>Administrator Sistem</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= MAIN CONTENT ================= -->
    <section class="main-content">
        <div class="container">

            <!-- INFO -->
            <div class="dashboard-info">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="info-content">
                        <h2 class="info-title">Tentang Dashboard Admin</h2>
                        <p class="info-description">
                            Dashboard Admin digunakan untuk mengelola data master sistem peminjaman ruangan,
                            termasuk ruang, user, serta melakukan konfirmasi awal peminjaman sebelum diteruskan
                            ke Warek.
                        </p>
                    </div>
                </div>
            </div>

            <!-- QUICK ACCESS -->
            <div class="quick-access">
                <h2 class="section-title">Akses Cepat</h2>

                <div class="quick-grid">

                    <a href="<?= BASEURL ?>/admin/ruang" class="quick-card">
                        <div class="quick-icon">
                            <i class="fas fa-door-open"></i>
                        </div>
                        <h3 class="quick-title">Manajemen Ruang</h3>
                        <p class="quick-desc">Tambah, ubah, dan hapus data ruangan</p>
                    </a>

                    <a href="<?= BASEURL ?>/admin/user" class="quick-card">
                        <div class="quick-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="quick-title">Manajemen User</h3>
                        <p class="quick-desc">Kelola akun peminjam dan admin</p>
                    </a>

                    <a href="<?= BASEURL ?>/admin/konfirmasi_peminjaman" class="quick-card">
                        <div class="quick-icon">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <h3 class="quick-title">Konfirmasi Peminjaman</h3>
                        <p class="quick-desc">Persetujuan awal peminjaman</p>
                    </a>

                    <a href="<?= BASEURL ?>/admin/konfirmasi_pengembalian" class="quick-card">
                        <div class="quick-icon">
                            <i class="fas fa-undo"></i>
                        </div>
                        <h3 class="quick-title">Pengembalian</h3>
                        <p class="quick-desc">Konfirmasi pengembalian ruangan</p>
                    </a>

                </div>
            </div>

        </div>
    </section>

    <!-- ================= FOOTER ================= -->
    <footer class="footer">
        <div class="container">
            <div class="footer-bottom">
                <p>&copy; 2024 MyRoom - ITS Mandala</p>
            </div>
        </div>
    </footer>

    <script src="<?= BASEURL ?>/assets/js/warek_dashboard.js"></script>
</body>

</html>