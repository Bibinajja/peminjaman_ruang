<?php
session_start();
header('Content-Type: application/json');

// Check if user is logged in and has Warek role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'warek') {
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized access'
    ]);
    exit();
}

// Database connection using existing Database class
require_once '../../core/Database.php';
$db = new Database();

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

// Validate input
if (!isset($input['peminjaman_id']) || !isset($input['action'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Data tidak lengkap'
    ]);
    exit();
}

$peminjaman_id = intval($input['peminjaman_id']);
$action = $input['action'];

// Validate action (only approve allowed for Warek)
if ($action !== 'approve') {
    echo json_encode([
        'success' => false,
        'message' => 'Aksi tidak valid'
    ]);
    exit();
}

// Get current peminjaman data
$query = "SELECT p.*, u.nama, u.email, r.nama_ruang 
          FROM peminjaman p
          JOIN users u ON p.user_id = u.user_id
          JOIN ruang r ON p.ruang_id = r.ruang_id
          WHERE p.peminjaman_id = :peminjaman_id AND p.status = :status";

$db->query($query);
$db->bind(':peminjaman_id', $peminjaman_id);
$db->bind(':status', 'konfirmasi_admin');
$peminjaman = $db->single();

if (!$peminjaman) {
    echo json_encode([
        'success' => false,
        'message' => 'Peminjaman tidak ditemukan atau sudah diproses'
    ]);
    exit();
}

try {
    // 1. Update peminjaman status to 'konfirmasi_warek' (approved by Warek)
    $db->query("UPDATE peminjaman 
                SET status = :status 
                WHERE peminjaman_id = :peminjaman_id");
    $db->bind(':status', 'konfirmasi_warek');
    $db->bind(':peminjaman_id', $peminjaman_id);
    $db->execute();

    if ($db->rowCount() === 0) {
        throw new Exception('Gagal mengupdate status peminjaman');
    }

    // 2. Get admin_id (use session user_id as warek acts as admin)
    $admin_id = $_SESSION['user_id'];

    // 3. Insert into admin_log
    $db->query("INSERT INTO admin_log (admin_id, aktivitas, waktu) 
                VALUES (:admin_id, :aktivitas, NOW())");
    $db->bind(':admin_id', $admin_id);
    $aktivitas = "Wakil Rektor menyetujui peminjaman ID: {$peminjaman_id} - Ruang: {$peminjaman['nama_ruang']} oleh {$peminjaman['nama']}";
    $db->bind(':aktivitas', $aktivitas);
    $db->execute();

    // 4. Insert into pembatalan table for tracking (status = 'diajukan' means approved flow)
    $db->query("INSERT INTO pembatalan 
                (peminjaman_id, user_id, alasan_pembatalan, tanggal, status) 
                VALUES (:peminjaman_id, :user_id, :alasan, CURDATE(), :status)");
    $db->bind(':peminjaman_id', $peminjaman_id);
    $db->bind(':user_id', $peminjaman['user_id']);
    $db->bind(':alasan', 'Disetujui oleh Wakil Rektor');
    $db->bind(':status', 'diajukan');
    $db->execute();

    // 5. Insert into pengembalian table for tracking
    $db->query("INSERT INTO pengembalian 
                (peminjaman_id, user_id, tanggal_pengembalian, bukti_kegiatan, status, alasan_penolakan_admin) 
                VALUES (:peminjaman_id, :user_id, CURDATE(), :bukti, :status, NULL)");
    $db->bind(':peminjaman_id', $peminjaman_id);
    $db->bind(':user_id', $peminjaman['user_id']);
    $db->bind(':bukti', 'Menunggu pengembalian');
    $db->bind(':status', 'diajukan');
    $db->execute();

    // Success response
    echo json_encode([
        'success' => true,
        'message' => 'Peminjaman berhasil disetujui oleh Wakil Rektor',
        'data' => [
            'peminjaman_id' => $peminjaman_id,
            'nama_peminjam' => $peminjaman['nama'],
            'ruangan' => $peminjaman['nama_ruang'],
            'status' => 'konfirmasi_warek'
        ]
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Terjadi kesalahan: ' . $e->getMessage()
    ]);
}
