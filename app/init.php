<?php

// Mulai session (Penting untuk Login dan menyimpan data user sementara)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Konfigurasi URL Dasar (Sesuaikan dengan folder XAMPP htdocs Anda)
// Contoh: http://localhost/nama_folder_proyek/public
// define('BASEURL', 'http://localhost/peminjaman_ruang/public/');

require_once 'core/App.php';
require_once 'core/Controller.php';
require_once 'core/Database.php';

// Opsional: Anda bisa menambahkan Flasher (Pesan Notifikasi) di sini nanti
// require_once 'Flasher.php';

// Memulai aplikasi
$app = new App;
