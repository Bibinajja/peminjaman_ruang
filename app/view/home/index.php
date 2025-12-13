<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyRoom - Sistem Peminjaman Ruang ITS Mandala</title>
    <link rel="stylesheet" href="../../../public/assets/css/landing.css">
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
                <li><a href="#home" class="nav-link">Home</a></li>
                <li><a href="#about" class="nav-link">About</a></li>
                <li><a href="#peminjaman" class="nav-link">Peminjaman Ruang</a></li>
                <li><a href="#team" class="nav-link">Team</a></li>
                <li><a href="#contact" class="nav-link">Contact</a></li>
            </ul>
            <div class="nav-right">
                <a href="app/view/home/login.php" class="profile-icon">
                    <i class="fas fa-user-circle"></i>
                </a>
                <div class="hamburger" id="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Selamat Datang di MyRoom</h1>
                <div class="typing-container">
                    <span class="typing-text" id="typingText"></span>
                    <span class="cursor">|</span>
                </div>
                <p class="hero-description">
                    MyRoom hadir sebagai bukti nyata komitmen ITS Mandala dalam menerapkan solusi teknologi 
                    untuk kehidupan kampus yang lebih baik. Gunakan MyRoom sekarang dan rasakan kemudahan 
                    mengelola ruang di ujung jari Anda!
                </p>
                <a href="app/view/home/login.php" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Login Sekarang
                </a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">About</h2>
                <div class="title-underline"></div>
            </div>
            <div class="about-content">
                <div class="about-card">
                    <div class="card-icon">
                        <i class="fas fa-university"></i>
                    </div>
                    <p class="about-text">
                        Institut Teknologi dan Sains Mandala (ITSM) Jember adalah perguruan tinggi swasta 
                        terakreditasi "Baik Sekali" yang berlokasi di Jember, Jawa Timur. Didirikan pada 
                        tahun 1978, ITSM berfokus pada pendidikan di bidang Ekonomi, Bisnis, Sains, dan 
                        Teknologi. Kami berdedikasi untuk menghasilkan lulusan yang inovatif, kompeten, 
                        dan siap bersaing di pasar global melalui program pendidikan berkualitas dan 
                        kemitraan internasional.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Peminjaman Ruang Section -->
    <section class="peminjaman" id="peminjaman">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">MyRoom Sistem Peminjaman Ruang</h2>
                <div class="title-underline"></div>
            </div>
            <div class="peminjaman-content">
                <div class="peminjaman-card">
                    <div class="card-icon-large">
                        <i class="fas fa-door-open"></i>
                    </div>
                    <p class="peminjaman-description">
                        Sebelum Anda mengeklik tombol "Pinjam Ruangan", pastikan Anda telah memeriksa 
                        ketersediaan jadwal secara real-time melalui kalender interaktif kami untuk 
                        menghindari double booking; proses di MyRoom sepenuhnya paperless, cepat, dan 
                        status peminjaman akan diinformasikan secara otomatis melalui notifikasi instan.
                    </p>
                    <a href="app/view/home/login.php" class="btn btn-secondary">
                        <i class="fas fa-calendar-plus"></i> Ajukan Peminjaman Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Cara Melakukan Peminjaman -->
    <section class="steps">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Cara Melakukan Peminjaman Ruang</h2>
                <div class="title-underline"></div>
            </div>
            <div class="steps-grid">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <div class="step-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="step-title">Cek Ketersediaan Ruangan</h3>
                    <p class="step-description">
                        Hal pertama yang harus Anda lakukan adalah memastikan ruangan yang Anda inginkan 
                        tidak sedang digunakan atau sudah dipesan.
                    </p>
                </div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <div class="step-icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    <h3 class="step-title">Mengisi Formulir Peminjaman</h3>
                    <p class="step-description">
                        Setelah Anda menemukan ruangan yang tersedia, segera isi formulir pengajuan 
                        peminjaman dengan data yang lengkap dan akurat.
                    </p>
                </div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <div class="step-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3 class="step-title">Tunggu Konfirmasi Status</h3>
                    <p class="step-description">
                        Setelah formulir diajukan, permohonan Anda akan melalui proses peninjauan oleh 
                        pihak berwenang.
                    </p>
                </div>
                <div class="step-card">
                    <div class="step-number">4</div>
                    <div class="step-icon">
                        <i class="fas fa-upload"></i>
                    </div>
                    <h3 class="step-title">Unggah Bukti Kegiatan</h3>
                    <p class="step-description">
                        Setelah Selesai lakukan unggah bukti kegiatan. Ini adalah langkah penting setelah 
                        kegiatan selesai dilakukan, sering kali diwajibkan sebagai bentuk pertanggungjawaban.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq" id="faq">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Frequently Asked Questions</h2>
                <div class="title-underline"></div>
            </div>
            <div class="faq-container">
                <div class="faq-item">
                    <button class="faq-question">
                        <span>Bagaimana cara mengetahui ketersediaan ruangan untuk tanggal tertentu?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Anda dapat mengecek ketersediaan ruangan melalui fitur Kalender Peminjaman atau Jadwal Ruangan yang tersedia di halaman utama platform ini. Anda cukup memasukkan tanggal dan rentang waktu yang diinginkan, dan sistem akan menampilkan ruangan mana saja yang masih kosong (tersedia).</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">
                        <span>Berapa lama waktu yang dibutuhkan sampai permohonan peminjaman saya disetujui?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Proses verifikasi dan persetujuan biasanya memerlukan waktu maksimal 1x24 jam pada hari kerja. Anda akan menerima notifikasi melalui email atau dapat mengecek langsung status permohonan Anda di dashboard akun setelah status berubah menjadi 'Diterima'.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">
                        <span>Apakah saya boleh meminjam ruangan di luar jam operasional normal (misalnya, akhir pekan)?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Peminjaman di luar jam operasional normal (termasuk akhir pekan) harus diajukan setidaknya 3 hari kerja sebelumnya dan memerlukan persetujuan khusus dari manajer fasilitas. Mohon berikan keterangan alasan yang jelas pada bagian "Keperluan Kegiatan" di formulir.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">
                        <span>Bagaimana prosedur pembatalan peminjaman ruangan?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Anda dapat membatalkan pemesanan ruangan yang sudah tercatat di sistem (dan muncul di Riwayat Peminjaman) dengan mengikuti langkah-langkah berikut:</p>
                        <ul>
                            <li><strong>Akses Profil:</strong> Masuk ke akun Anda dan buka bagian Profil atau Dashboard pengguna.</li>
                            <li><strong>Kunjungi Riwayat:</strong> Pilih menu Riwayat Peminjaman untuk melihat daftar pemesanan Anda.</li>
                            <li><strong>Isi Formulir Pembatalan:</strong> Pilih pemesanan yang ingin Anda batalkan dan isi formulir pembatalan yang tersedia pada detail pemesanan tersebut.</li>
                            <li><strong>Konfirmasi:</strong> Setelah formulir dikirim, pastikan status pemesanan tersebut di riwayat Anda telah berubah menjadi "Dibatalkan".</li>
                        </ul>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">
                        <span>Apakah saya perlu mengembalikan ruangan dalam kondisi tertentu setelah selesai menggunakannya?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Ya, peminjam wajib mengembalikan ruangan dalam kondisi yang sama baiknya seperti sebelum digunakan. Hal ini meliputi:</p>
                        <ul>
                            <li>Memastikan semua sampah telah dibuang.</li>
                            <li>Mematikan semua peralatan elektronik (AC, lampu, proyektor).</li>
                            <li>Merapi dan menata kembali perabotan sesuai tata letak standar (jika sempat diubah).</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team" id="team">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Our Team</h2>
                <div class="title-underline"></div>
            </div>
            <div class="team-grid">
                <div class="team-card">
                    <div class="team-image">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h3 class="team-name">Muhammad Bintoro</h3>
                    <p class="team-nim">NIM: 24060009</p>
                </div>
                <div class="team-card">
                    <div class="team-image">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h3 class="team-name">Nizar</h3>
                    <p class="team-nim">NIM: 2406</p>
                </div>
                <div class="team-card">
                    <div class="team-image">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h3 class="team-name">Rianto Dian Maulana</h3>
                    <p class="team-nim">NIM: 24060001</p>
                </div>
                <div class="team-card">
                    <div class="team-image">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h3 class="team-name">Faqi Agustinus</h3>
                    <p class="team-nim">NIM: 24060032</p>
                </div>
                <div class="team-card">
                    <div class="team-image">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h3 class="team-name">Moh Irfandi</h3>
                    <p class="team-nim">NIM: 24060058</p>
                </div>
                <div class="team-card">
                    <div class="team-image">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h3 class="team-name">Anak Hilang</h3>
                    <p class="team-nim">Coming Soon</p>
                </div>
                <div class="team-card">
                    <div class="team-image">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h3 class="team-name">Anak Hilang</h3>
                    <p class="team-nim">Coming Soon</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="contact">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Contact Us</h2>
                <div class="title-underline"></div>
            </div>
            <div class="contact-grid">
                <div class="contact-map">
                    <h3>Peta Lokasi ITS Mandala</h3>
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3949.2969874067647!2d113.7066!3d-8.1669!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd695b61f2e9f6f%3A0x4027a76e352e6f0!2sInstitut%20Teknologi%20dan%20Sains%20Mandala!5e0!3m2!1sen!2sid!4v1234567890" 
                        width="100%" 
                        height="100%" 
                        style="border:0; border-radius: 12px;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
                <div class="contact-info">
                    <h3>Informasi Kontak</h3>
                    <div class="contact-details">
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <h4>Alamat</h4>
                                <p>Jember, Jawa Timur, Indonesia</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <h4>Telepon</h4>
                                <p>+62 831-2931-3931</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <h4>Email</h4>
                                <p>info@itsmandala.ac.id</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <h4>Jam Operasional</h4>
                                <p>Senin - Jumat (07.00 - 16.00 WIB)</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="contact-form">
                        <h3>Kirim Pesan via WhatsApp</h3>
                        <form id="whatsappForm">
                            <div class="form-group">
                                <input type="text" id="name" placeholder="Nama Lengkap" required>
                            </div>
                            <div class="form-group">
                                <input type="email" id="email" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <textarea id="pesan" rows="4" placeholder="Pesan Anda" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-whatsapp">
                                <i class="fab fa-whatsapp"></i> Kirim via WhatsApp
                            </button>
                        </form>
                    </div>
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

    <script src="../../../public/assets/js/landing.js"></script>
</body>
</html>