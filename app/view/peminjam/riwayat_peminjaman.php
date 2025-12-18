<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul'] ?? 'Riwayat Peminjaman' ?> - MyRoom</title>
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
    </style>
</head>
<body>

<div class="container">
    <h3 class="page-title">📜 Riwayat Peminjaman Ruang</h3>

    <?php if (!empty($data['riwayat'])): ?>
        <?php foreach ($data['riwayat'] as $row): ?>
            <?php
            $status = $row['status'] ?? 'pending';
            // Menyesuaikan warna badge berdasarkan status di database
            $badge = ($status === 'disetujui' || $status === 'konfirmasi_warek') ? 'bg-success' : 
                    ($status === 'ditolak' ? 'bg-danger' : 'bg-warning text-dark');
            
            $statusText = ($status === 'disetujui' || $status === 'konfirmasi_warek') ? 'Disetujui' : 
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
                <p class="mb-1"><strong>Pemohon:</strong> <?= htmlspecialchars($row['nama_peminjam'] ?? 'Tidak ada') ?></p>
                <p class="mb-2"><strong>Keperluan:</strong> <?= htmlspecialchars($row['keperluan']) ?></p>
                
                <?php if ($status === 'pending' || $status === 'menunggu konfirmasi'): ?>
                    <div class="mt-3 text-end">
                        <a href="<?= BASEURL ?>/peminjam/form_pembatalan/<?= $row['peminjaman_id'] ?>" 
                           class="btn btn-outline-danger btn-sm" 
                           onclick="return confirm('Apakah Anda yakin ingin membatalkan peminjaman ini?')">
                           ❌ Batalkan Peminjaman
                        </a>
                    </div>
                <?php endif; ?>
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