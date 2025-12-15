<?php
session_start();
require_once '../../core/Database.php';
$db = new Database();

// Hanya admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Proses aksi konfirmasi (jika ada)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $status = $_GET['action'] === 'setujui' ? 'disetujui' : 'ditolak';
    $db->query("UPDATE peminjaman SET status = :status WHERE id = :id");
    $db->bind(':status', $status);
    $db->bind(':id', $id);
    $db->execute();
    header("Location: konfirmasi_peminjaman.php");
    exit();
}

try {
    $db->query("
        SELECT p.*, r.nama_ruang 
        FROM peminjaman p 
        JOIN ruang r ON p.ruang_id = r.ruang_id 
        ORDER BY p.created_at DESC
    ");
    $peminjaman = $db->resultSet();
} catch (Exception $e) {
    $peminjaman = [];
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Peminjaman - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4">Konfirmasi Peminjaman Ruangan</h2>
    <table class="table table-bordered table-hover">
        <thead class="table-primary">
            <tr>
                <th>No</th>
                <th>Pemohon</th>
                <th>Ruang</th>
                <th>Waktu</th>
                <th>Keperluan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($peminjaman as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama_peminjam']) ?></td>
                    <td><?= htmlspecialchars($row['nama_ruang']) ?></td>
                    <td>
                        <?= date('d/m/Y H:i', strtotime($row['tanggal_mulai'])) ?> - 
                        <?= date('d/m/Y H:i', strtotime($row['tanggal_selesai'])) ?>
                    </td>
                    <td><?= htmlspecialchars($row['keperluan']) ?></td>
                    <td>
                        <span class="badge <?= $row['status'] == 'disetujui' ? 'bg-success' : ($row['status'] == 'ditolak' ? 'bg-danger' : 'bg-warning') ?>">
                            <?= ucfirst($row['status']) ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($row['status'] == 'pending'): ?>
                            <a href="?action=setujui&id=<?= $row['id'] ?>" class="btn btn-sm btn-success">Setujui</a>
                            <a href="?action=tolak&id=<?= $row['id'] ?>" class="btn btn-sm btn-danger">Tolak</a>
                        <?php else: ?>
                            <small class="text-muted">Sudah diproses</small>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>