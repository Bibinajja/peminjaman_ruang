<?php
session_start();
require_once '../../core/Database.php';
$db = new Database();

// Cek login (sesuaikan dengan session login kamu)
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // sesuaikan path login
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id       = $_SESSION['user_id'];
    $ruang_id      = $_POST['ruang_id'] ?? '';
    $nama_peminjam = trim($_POST['nama_peminjam'] ?? '');
    $tanggal_mulai = $_POST['tanggal_mulai'] . ' ' . ($_POST['jam_mulai'] ?? '') . ':00';
    $tanggal_selesai = $_POST['tanggal_selesai'] . ' ' . ($_POST['jam_selesai'] ?? '') . ':00';
    $keperluan     = trim($_POST['keperluan'] ?? '');

    // Validasi
    if (empty($ruang_id) || empty($nama_peminjam) || empty($tanggal_mulai) || empty($tanggal_selesai) || empty($keperluan)) {
        $_SESSION['msg'] = "error|Harap isi semua field!";
        header("Location: form_peminjaman.php?ruang_id=$ruang_id");
        exit();
    }

    try {
        $db->query("INSERT INTO peminjaman 
                    (user_id, ruang_id, nama_peminjam, tanggal_mulai, tanggal_selesai, keperluan, status, created_at) 
                    VALUES 
                    (:user_id, :ruang_id, :nama_peminjam, :tgl_mulai, :tgl_selesai, :keperluan, 'pending', NOW())");

        $db->bind(':user_id', $user_id);
        $db->bind(':ruang_id', $ruang_id);
        $db->bind(':nama_peminjam', $nama_peminjam);
        $db->bind(':tgl_mulai', $tanggal_mulai);
        $db->bind(':tgl_selesai', $tanggal_selesai);
        $db->bind(':keperluan', $keperluan);
        $db->execute();

        // Simpan pesan sukses untuk popup di riwayat
        $_SESSION['msg'] = "success|Peminjaman ruangan berhasil diajukan! Menunggu konfirmasi admin.";

        header("Location: riwayat_peminjaman.php");
        exit();

    } catch (Exception $e) {
        $_SESSION['msg'] = "error|Gagal mengajukan peminjaman.";
        header("Location: form_peminjaman.php?ruang_id=$ruang_id");
        exit();
    }
} else {
    header("Location: form_peminjaman.php");
    exit();
}
?>