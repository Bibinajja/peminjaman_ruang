<!DOCTYPE html>
<html lang="id">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyRoom - Sistem Peminjaman Ruang ITS Mandala</title>
    <link rel="stylesheet" href="<?= BASEURL ?>/assets/css/landing.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>


<body>
    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <div class="nav-logo">MyRoom</div>
            <div class="nav-menu" id="navMenu">
                <a href="#home" class="nav-link">Home</a>
                <a href="#about" class="nav-link">About</a>
                <a href="#peminjaman" class="nav-link">Peminjaman Ruang</a>
                <a href="#team" class="nav-link">Team</a>
                <a href="#contact" class="nav-link">Contact</a>
            </div>
            <a href="<?= BASEURL ?>profil" class="nav-profile">
                <i class="fas fa-user-circle"></i>
            </a>
            <div class="nav-toggle" id="navToggle">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="hero-title">Selamat Datang di <span class="typing-text" id="typingText"></span></h1>
            <p class="hero-description">
                MyRoom hadir sebagai bukti nyata komitmen ITS Mandala dalam menerapkan solusi teknologi untuk kehidupan kampus yang lebih baik. Gunakan MyRoom sekarang dan rasakan kemudahan mengelola ruang di ujung jari Anda!
            </p>
            <button class="btn-primary" onclick="window.location.href='<?php echo BASEURL; ?>/home/login'">
                <i class="fas fa-sign-in-alt"></i> Login Sekarang
            </button>
        </div>
    </section>

    <!-- About Section -->
    <section class="section about-section" id="about">
        <div class="container">
            <h2 class="section-title fade-in">About</h2>
            <div class="about-content fade-in">
                <p>
                    Institut Teknologi dan Sains Mandala (ITSM) Jember adalah perguruan tinggi swasta terakreditasi "Baik Sekali" yang berlokasi di Jember, Jawa Timur. Didirikan pada tahun 1978, ITSM berfokus pada pendidikan di bidang Ekonomi, Bisnis, Sains, dan Teknologi. Kami berdedikasi untuk menghasilkan lulusan yang inovatif, kompeten, dan siap bersaing di pasar global melalui program pendidikan berkualitas dan kemitraan internasional.
                </p>
            </div>
        </div>
    </section>

    <!-- Peminjaman Ruang Section -->
    <section class="section peminjaman-section" id="peminjaman">
        <div class="container">
            <h2 class="section-title fade-in">MyRoom Sistem Peminjaman Ruang</h2>
            <div class="peminjaman-box fade-in">
                <div class="peminjaman-icon">
                    <i class="fas fa-building"></i>
                </div>
                <p class="peminjaman-description">
                    Sebelum Anda mengeklik tombol "Pinjam Ruangan", pastikan Anda telah memeriksa ketersediaan jadwal secara real-time melalui kalender interaktif kami untuk menghindari double booking; proses di MyRoom sepenuhnya paperless, cepat, dan status peminjaman akan diinformasikan secara otomatis melalui notifikasi instan.
                </p>
                <button class="btn btn-primary"
    onclick="window.location.href='<?= BASEURL; ?>/peminjam/cek_ketersediaan'">
    <i class="fas fa-door-open"></i> Cek Ketersediaan Ruang
</button>

            </div>
        </div>
    </section>

    <!-- Cara Melakukan Peminjaman -->
    <section class="section steps-section">
        <div class="container">
            <h2 class="section-title fade-in">Cara Melakukan Peminjaman Ruang</h2>
            <div class="steps-grid">
                <div class="step-card fade-in">
                    <div class="step-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="step-number">01</div>
                    <h3>Cek Ketersediaan Ruangan</h3>
                    <p>Hal pertama yang harus Anda lakukan adalah memastikan ruangan yang Anda inginkan tidak sedang digunakan atau sudah dipesan.</p>
                </div>
                <div class="step-card fade-in">
                    <div class="step-icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    <div class="step-number">02</div>
                    <h3>Mengisi Formulir Peminjaman</h3>
                    <p>Setelah Anda menemukan ruangan yang tersedia, segera isi formulir pengajuan peminjaman dengan data yang lengkap dan akurat.</p>
                </div>
                <div class="step-card fade-in">
                    <div class="step-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="step-number">03</div>
                    <h3>Tunggu Konfirmasi Status</h3>
                    <p>Setelah formulir diajukan, permohonan Anda akan melalui proses peninjauan oleh pihak berwenang.</p>
                </div>
                <div class="step-card fade-in">
                    <div class="step-icon">
                        <i class="fas fa-upload"></i>
                    </div>
                    <div class="step-number">04</div>
                    <h3>Unggah Bukti Kegiatan</h3>
                    <p>Setelah Selesai lakukan unggahan bukti kegiatan. Ini adalah langkah penting setelah kegiatan selesai dilakukan, sering kali diwajibkan sebagai bentuk pertanggungjawaban.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="section faq-section">
        <div class="container">
            <h2 class="section-title fade-in">Frequently Asked Questions</h2>
            <div class="faq-container">
                <div class="faq-item fade-in">
                    <button class="faq-question">
                        <span>Bagaimana cara mengetahui ketersediaan ruangan untuk tanggal tertentu?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Anda dapat mengecek ketersediaan ruangan melalui fitur Kalender Peminjaman atau Jadwal Ruangan yang tersedia di halaman utama platform ini. Anda cukup memasukkan tanggal dan rentang waktu yang diinginkan, dan sistem akan menampilkan ruangan mana saja yang masih kosong (tersedia).</p>
                    </div>
                </div>
                <div class="faq-item fade-in">
                    <button class="faq-question">
                        <span>Berapa lama waktu yang dibutuhkan sampai permohonan peminjaman saya disetujui?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Proses verifikasi dan persetujuan biasanya memerlukan waktu maksimal 1x24 jam pada hari kerja. Anda akan menerima notifikasi melalui email atau dapat mengecek langsung status permohonan Anda di dashboard akun setelah status berubah menjadi 'Diterima'.</p>
                    </div>
                </div>
                <div class="faq-item fade-in">
                    <button class="faq-question">
                        <span>Apakah saya boleh meminjam ruangan di luar jam operasional normal (misalnya, akhir pekan)?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Peminjaman di luar jam operasional normal (termasuk akhir pekan) harus diajukan setidaknya 3 hari kerja sebelumnya dan memerlukan persetujuan khusus dari manajer fasilitas. Mohon berikan keterangan alasan yang jelas pada bagian "Keperluan Kegiatan" di formulir.</p>
                    </div>
                </div>
                <div class="faq-item fade-in">
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
                <div class="faq-item fade-in">
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
    <section class="section team-section" id="team">
        <div class="container">
            <h2 class="section-title fade-in">Our Team</h2>
            <div class="team-slider">
                <button class="slider-btn prev-btn" id="prevBtn">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div class="team-container" id="teamContainer">
                    <div class="team-card">
                        <div class="team-image">
                            <img src="<?= BASEURL ?>assets/img/bintoro.jpg" alt="Muhammad Bintoro" onerror="this.parentElement.innerHTML='<i class=\'fas fa-user\'></i>'">
                        </div>
                        <h3>Muhammad Bintoro</h3>
                        <p class="team-nim">NIM: 24060009</p>
                    </div>
                    <div class="team-card">
                        <div class="team-image">
                            <img src="<?= BASEURL ?>assets/img/nizar.jpg" alt="Nizar Fanani" onerror="this.parentElement.innerHTML='<i class=\'fas fa-user\'></i>'">
                        </div>
                        <h3>Nizar Fanani</h3>
                        <p class="team-nim">NIM: 24060048</p>
                    </div>
                    <div class="team-card">
                        <div class="team-image">
                            <img src="<?= BASEURL ?>assets/img/riyan.jpg" alt="Rianto Dian Maulana" onerror="this.parentElement.innerHTML='<i class=\'fas fa-user\'></i>'">
                        </div>
                        <h3>Rianto Dian Maulana</h3>
                        <p class="team-nim">NIM: 24060001</p>
                    </div>
                    <div class="team-card">
                        <div class="team-image">
                            <img src="<?= BASEURL ?>assets/img/faqih.jpg" alt="Faqi Agustinus" onerror="this.parentElement.innerHTML='<i class=\'fas fa-user\'></i>'">
                        </div>
                        <h3>Faqi Agustinus</h3>
                        <p class="team-nim">NIM: 24060032</p>
                    </div>
                    <div class="team-card">
                        <div class="team-image">
                            <img src="<?= BASEURL ?>assets/img/irfandi.jpg" alt="Moh Irfandi" onerror="this.parentElement.innerHTML='<i class=\'fas fa-user\'></i>'">
                        </div>
                        <h3>Moh Irfandi</h3>
                        <p class="team-nim">NIM: 24060058</p>
                    </div>
                    <div class="team-card">
                        <div class="team-image">
                            <img src="<?= BASEURL ?>assets/img/laila.jpeg" alt="Lailatul Badriyah" onerror="this.parentElement.innerHTML='<i class=\'fas fa-user\'></i>'">
                        </div>
                        <h3>Lailatul Badriyah</h3>
                        <p class="team-nim">NIM: 24060016</p>
                    </div>
                    <div class="team-card">
                        <div class="team-image">
                            <img src="<?= BASEURL ?>assets/img/tsaqiev.jpg" alt="Tsaqiev Achmad Basayv" onerror="this.parentElement.innerHTML='<i class=\'fas fa-user\'></i>'">
                        </div>
                        <h3>Tsaqiev Achmad Basayv</h3>
                        <p class="team-nim">NIM: 24060004</p>
                    </div>
                </div>
                <button class="slider-btn next-btn" id="nextBtn">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section contact-section" id="contact">
        <div class="container">
            <h2 class="section-title fade-in">Contact Us</h2>
            <div class="contact-grid">
                <div class="contact-map fade-in">
                    <h3>Peta Lokasi ITS Mandala</h3>
                    <iframe
                        <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3949.3!2d113.7!3d-8.17!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOMKwMTAnMTIuMCJTIDExM8KwNDInMDAuMCJF!5e0!3m2!1sen!2sid!4v1234567890"
                        width="100%"
                        height="350"
                        style="border:0; border-radius: 15px;"
                        allowfullscreen=""
                        width="100%"
                        height="350"
                        style="border:0; border-radius: 15px;"
                        allowfullscreen=""
                        loading="lazy">
                    </iframe>
                </div>
                <div class="contact-info fade-in">
                    <div class="info-box">
                        <h3>Informasi Kontak</h3>
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <a href="https://maps.app.goo.gl/1Bk6QgeT31Cdvtzu7" target="_blank">ITS Mandala, Jember, Jawa Timur</a>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-phone"></i>
                            <span>+62 831-2931-3931</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-envelope"></i>
                            <span>info@itsmandala.ac.id</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-clock"></i>
                            <span>Senin - Jumat (07.00 - 16.00 WIB)</span>
                        </div>
                    </div>
                    <form class="contact-form" id="contactForm">
                        <h3>Kirim Pesan via WhatsApp</h3>
                        <input type="text" placeholder="Nama Anda" id="contactName" required>
                        <input type="email" placeholder="Email Anda" id="contactEmail" required>
                        <textarea placeholder="Pesan Anda" rows="4" id="contactMessage" required></textarea>
                        <button type="submit" class="btn-whatsapp">
                            <i class="fab fa-whatsapp"></i> Kirim via WhatsApp
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h4>MyRoom</h4>
                    <p>Sistem Peminjaman Ruang ITS Mandala - Solusi digital untuk kemudahan kampus</p>
                </div>
                <div class="footer-col">
                    <h4>Kontak</h4>
                    <p><i class="fas fa-envelope"></i> info@itsmandala.ac.id</p>
                    <p><i class="fas fa-phone"></i> +62 831-2931-3931</p>
                </div>
                <div class="footer-col">
                    <h4>Lokasi</h4>
                    <p><i class="fas fa-map-marker-alt"></i> <a href="https://maps.app.goo.gl/1Bk6QgeT31Cdvtzu7" target="_blank">ITS Mandala, Jember</a></p>
                    <p><i class="fas fa-clock"></i> Senin - Jumat (07.00 - 16.00)</p>
                </div>
                <div class="footer-col">
                    <h4>Social Media</h4>
                    <div class="social-links">

                        <a href="https://youtube.com/@itsmandala2788" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-youtube"></i>
                        </a>

                        <a href="https://instagram.com/itsmandala.official" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-instagram"></i>
                        </a>

                        <a href="https://facebook.com/stiemandala.akunresmi" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-facebook-f"></i>
                        </a>

                        <a href="https://tiktok.com/@itsm.top" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 MyRoom - ITS Mandala. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Login Popup Modal -->
    <div class="modal" id="loginModal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal()">&times;</span>
            <div class="modal-icon">
                <i class="fas fa-lock"></i>
            </div>
            <h3>Login Diperlukan</h3>
            <p>Anda harus login terlebih dahulu untuk mengecek ketersediaan ruangan dan mengajukan peminjaman.</p>
            <div class="modal-buttons">
                <button class="btn-primary" onclick="redirectToLogin()">
                    <i class="fas fa-sign-in-alt"></i> Login Sekarang
                </button>
                <button class="btn-secondary" onclick="closeModal()">Batal</button>
            </div>
        </div>
    </div>

    <script src="../../../public/assets/js/landing.js"></script>
</body>


</html>