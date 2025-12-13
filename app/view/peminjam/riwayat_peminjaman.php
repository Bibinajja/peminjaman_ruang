<!DOCTYPE html>
<html lang="id">
<head>
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

        .container {
            padding-top: 40px;
            padding-bottom: 40px;
        }

        .page-title {
            color: #fff;
            font-weight: 600;
            margin-bottom: 30px;
        }

        .history-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.15);
            animation: slideUp 0.7s ease;
            transition: 0.3s;
        }

        .history-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 40px rgba(0,0,0,0.2);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .icon {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .badge-status {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
        }
    </style>
</head>

<body>

<div class="container">

    <h3 class="page-title">📜 Riwayat Peminjaman Ruang</h3>

    <?php if (!empty($data)) : ?>
        <?php foreach ($data as $row) : ?>

            <?php
            $badge = match($row['status']) {
                'Disetujui' => 'bg-success',
                'Ditolak'   => 'bg-danger',
                'Menunggu'  => 'bg-warning',
                default     => 'bg-secondary'
            };
            ?>

            <div class="history-card">
                <div class="d-flex align-items-center gap-3">

                    <div class="icon">🏢</div>

                    <div class="flex-grow-1">
                        <h5 class="mb-1">
                            <?= htmlspecialchars($row['nama_ruang'] ?? 'Ruang Tidak Diketahui') ?>
                        </h5>
                        <small class="text-muted">
                            📅 <?= htmlspecialchars($row['tanggal']) ?>
                        </small>
                    </div>

                    <span class="badge badge-status <?= $badge ?>">
                        <?= $row['status'] ?>
                    </span>

                </div>

                <hr>

                <p class="mb-0">
                    <strong>Pemohon:</strong>
                    <?= htmlspecialchars($row['nama_pemohon']) ?>
                </p>
            </div>

        <?php endforeach; ?>
    <?php else : ?>
        <div class="alert alert-light text-center">
            Belum ada riwayat peminjaman
        </div>
    <?php endif; ?>

</div>

</body>
</html>
