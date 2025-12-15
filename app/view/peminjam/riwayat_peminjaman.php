<?php
session_start();
require_once '../../core/Database.php';
$db = new Database();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    $db->query("
        SELECT p.*, r.nama_ruang 
        FROM peminjaman p 
        JOIN ruang r ON p.ruang_id = r.ruang_id 
        WHERE p.user_id = :user_id 
        ORDER BY p.created_at DESC
    ");
    $db->bind(':user_id', $user_id);
    $data = $db->resultSet();
} catch (Exception $e) {
    $data = [];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman Ruang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(120deg, #1e3c72, #2a5298, #3b82f6);
            background-size: 400% 400%;
            animation: gradientMove 12s ease infinite;
            font-family: 'Segoe UI', sans-serif;
        }
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .container { padding: 40px 20px; }
        .page-title { color: #fff; font-weight: 600; margin-bottom: 30px; }
        .history-card {
            background: #ffffff; border-radius: 16px; padding: 20px; margin-bottom: 20px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.15); transition: 0.3s;
        }
        .history-card:hover { transform: translateY(-6px); box-shadow: 0 18px 40px rgba(0,0,0,0.2); }
        .icon { width: 55px; height: 55px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #1e40af);
                color: #fff; display: flex; align-items: center; justify-content: center; font-size: 24px; }
        .badge-status { padding: 6px 14px; border-radius: 20px; font-size: 13px; }
    </style>
</head>
<body>

<div class="container">
    <h3 class="page-title">📜 Riwayat Peminjaman Ruang</h3>

    <!-- Popup Pesan Sukses -->
    <?php if (isset($_SESSION['msg'])): 
        list($type, $pesan) = explode('|', $_SESSION['msg'], 2);
    ?>
        <script>alert("<?= $pesan ?>");</script>
        <?php unset($_SESSION['msg']); ?>
    <?php endif; ?>

    <?php if (!empty($data)): ?>
        <?php foreach ($data as $row): ?>
            <?php
            $status = $row['status'] ?? 'pending';
            $badge = $status === 'disetujui' ? 'bg-success' : 
                    ($status === 'ditolak' ? 'bg-danger' : 'bg-warning text-dark');
            $statusText = $status === 'disetujui' ? 'Disetujui' : 
                         ($status === 'ditolak' ? 'Ditolak' : 'Menunggu Konfirmasi');
            ?>
            <div class="history-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon">🏢</div>
                    <div class="flex-grow-1">
                        <h5 class="mb-1"><?= htmlspecialchars($row['nama_ruang']) ?></h5>
                        <small class="text-muted">
                            📅 <?= date('d M Y H:i', strtotime($row['tanggal_mulai'])) ?> 
                            s/d <?= date('H:i', strtotime($row['tanggal_selesai'])) ?>
                        </small>
                    </div>
                    <span class="badge <?= $badge ?>"><?= $statusText ?></span>
                </div>
                <hr>
                <p class="mb-1"><strong>Pemohon:</strong> <?= htmlspecialchars($row['nama_peminjam']) ?></p>
                <p class="mb-0"><strong>Keperluan:</strong> <?= htmlspecialchars($row['keperluan']) ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-light text-center p-5">
            <h5>Belum ada riwayat peminjaman</h5>
            <p>Ajukan peminjaman ruangan terlebih dahulu.</p>
        </div>
    <?php endif; ?>
</div>

</body>
</html>