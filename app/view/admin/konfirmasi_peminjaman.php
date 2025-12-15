<!DOCTYPE html>
<html lang="id">

<head>
    <title>Daftar Permohonan - SDM</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f2f6fc;
            font-family: 'Segoe UI', sans-serif;
        }

        .topbar {
            background: #ffffff;
            padding: 15px 25px;
            border-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .topbar h3 {
            margin: 0;
            font-weight: 600;
        }

        .content {
            padding: 25px;
        }

        .card {
            border: none;
            border-radius: 14px;
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
        }

        .icon-box {
            width: 60px;
            height: 60px;
            background: #e9f1ff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <div class="content">

        <div class="topbar">
            <h3>Daftar Permohonan Peminjaman Ruang</h3>
            <a href="logout.php" class="btn btn-outline-danger">Logout</a>
        </div>

        <div class="row g-4">

            <?php if (!empty($data['peminjaman'])) : ?>
                <?php foreach ($data['peminjaman'] as $row): ?>


                    <?php
                    $badge = match ($row['status']) {
                        'Disetujui' => 'bg-success',
                        'Ditolak'   => 'bg-danger',
                        'Menunggu'  => 'bg-warning',
                        default     => 'bg-secondary'
                    };
                    ?>

                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="card shadow-sm h-100">

                            <div class="card-body">

                                <div class="icon-box">
                                    🏢
                                </div>

                                <h5 class="card-title mb-1">
                                    <?= htmlspecialchars($row['nama_pemohon']) ?>
                                </h5>

                                <small class="text-muted d-block mb-2">
                                    Ruang: <?= htmlspecialchars($row['nama_ruang'] ?? 'Tidak ada') ?>
                                </small>

                                <p class="mb-2">
                                    📅 <?= htmlspecialchars($row['tanggal']) ?>
                                </p>

                                <span class="badge <?= $badge ?> px-3 py-2">
                                    <?= $row['status'] ?>
                                </span>

                            </div>

                            <div class="card-footer bg-white text-center">
                                <a href="detail_permohonan.php?id=<?= $row['id'] ?>"
                                    class="btn btn-info btn-sm w-100">
                                    Periksa
                                </a>
                            </div>

                        </div>
                    </div>

                <?php endforeach; ?>
            <?php else : ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        Belum ada permohonan peminjaman ruang
                    </div>
                </div>
            <?php endif; ?>

        </div>

    </div>

</body>

</html>