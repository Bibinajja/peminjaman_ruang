<?php
session_start();
require_once '../../core/Database.php';
$db = new Database();

// Pastikan user sudah login (sesuaikan dengan sistem login kamu)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $user_id        = $_SESSION['user_id']; // atau nama user jika pakai session lain
    $ruang_id       = $_POST['ruang_id'] ?? '';
    $nama_peminjam  = trim($_POST['nama_peminjam'] ?? '');
    $tanggal_mulai  = $_POST['tanggal_mulai'] ?? '';
    $jam_mulai      = $_POST['jam_mulai'] ?? '';
    $tanggal_selesai = $_POST['tanggal_selesai'] ?? '';
    $jam_selesai    = $_POST['jam_selesai'] ?? '';
    $keperluan      = trim($_POST['keperluan'] ?? '');

    // Validasi sederhana
    if (
        empty($ruang_id) || empty($nama_peminjam) || empty($tanggal_mulai) || empty($jam_mulai) ||
        empty($tanggal_selesai) || empty($jam_selesai) || empty($keperluan)
    ) {
        $_SESSION['error'] = "Semua field harus diisi!";
        header("Location: form_peminjaman.php?ruang_id=$ruang_id&tanggal=$tanggal_mulai");
        exit();
    }

    // Gabung tanggal + jam jadi datetime
    $waktu_mulai    = "$tanggal_mulai $jam_mulai:00";
    $waktu_selesai  = "$tanggal_selesai $jam_selesai:00";

    try {
        // Insert ke tabel peminjaman
        $query = "INSERT INTO peminjaman 
                  (user_id, ruang_id, nama_peminjam, tanggal_mulai, tanggal_selesai, keperluan, status, created_at) 
                  VALUES 
                  (:user_id, :ruang_id, :nama_peminjam, :tanggal_mulai, :tanggal_selesai, :keperluan, 'pending', NOW())";

        $db->query($query);
        $db->bind(':user_id', $user_id);
        $db->bind(':ruang_id', $ruang_id);
        $db->bind(':nama_peminjam', $nama_peminjam);
        $db->bind(':tanggal_mulai', $waktu_mulai);
        $db->bind(':tanggal_selesai', $waktu_selesai);
        $db->bind(':keperluan', $keperluan);

        $db->execute();

        // Set success message untuk popup
        $_SESSION['success'] = "Peminjaman ruangan berhasil diajukan! Menunggu persetujuan admin.";

        // Redirect ke riwayat
        header("Location: riwayat_peminjaman.php");
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = "Gagal menyimpan peminjaman: " . $e->getMessage();
        header("Location: form_peminjaman.php?ruang_id=$ruang_id&tanggal=$tanggal_mulai");
        exit();
    }
} else {
    header("Location: form_peminjaman.php");
    exit();
}
