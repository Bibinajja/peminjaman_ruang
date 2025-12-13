<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Permintaan Pembatalan - SDM</title>
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
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .topbar h3 {
            margin: 0;
            font-weight: 600;
        }

        .content {
            padding: 25px;
        }

        .card-table {
            border: none;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .table thead th {
            background-color: #0d6efd;
            color: white;
            border: none;
            vertical-align: middle;
        }
        
        .table tbody tr:hover {
            background-color: #e9f1ff;
        }

        .table-striped > tbody > tr:nth-of-type(odd) > * {
            background-color: #f7f9fc;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
    </style>
</head>

<body>

<div class="content">

    <div class="topbar">
        <h3>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-calendar-x me-2" viewBox="0 0 16 16">
                <path d="M6.146 7.146a.5.5 0 0 1 .708 0L8 8.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 9l1.147 1.146a.5.5 0 0 1-.708.708L8 9.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 9l-1.147-1.146a.5.5 0 0 1 0-.708z"/>
                <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2z"/>
            </svg>
            Daftar Permintaan Pembatalan Ruangan
        </h3>
        <a href="/admin/dashboard" class="btn btn-outline-secondary">
             Kembali ke Dashboard
        </a>
    </div>

    <div class="card card-table">
        <div class="card-body p-0">
            
            <div class="p-3">
                <p class="mb-0 text-muted">Berikut adalah daftar permintaan pembatalan peminjaman yang perlu Anda konfirmasi.</p>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 5%;">ID</th>
                            <th scope="col" style="width: 20%;">Peminjam</th>
                            <th scope="col" style="width: 15%;">Ruang</th>
                            <th scope="col" style="width: 15%;">Tanggal</th>
                            <th scope="col" style="width: 35%;">Alasan Pembatalan</th>
                            <th scope="col" style="width: 10%;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($data['pembatalan']) && !empty($data['pembatalan'])): ?>
                            <?php foreach ($data['pembatalan'] as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['id']) ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($item['peminjam']) ?></strong>
                                    </td>
                                    <td><?= htmlspecialchars($item['ruang']) ?></td>
                                    <td><?= htmlspecialchars($item['tanggal']) ?></td>
                                    <td class="text-wrap">
                                        <small class="text-danger"><?= htmlspecialchars($item['alasan']) ?></small>
                                    </td>
                                    <td class="text-center">
                                        <form action="/admin/konfirmasi_pembatalan" method="post" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= htmlspecialchars($item['id']) ?>">
                                            <button type="submit" name="action" value="confirm" class="btn btn-success btn-sm"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Konfirmasi Pembatalan">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.38a.733.733 0 0 1 1.04-.945l2.67 2.67L12.736 3.97z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="alert alert-warning mb-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill me-2" viewBox="0 0 16 16">
                                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34-.34.65-.7.65-.25 0-.46-.14-.59-.34L6.2 10.02c-.08-.12-.03-.28.1-.38l.6-.45c.24-.18.39-.47.39-.78V7.05c0-.42-.34-.76-.76-.76h-.25c-.28 0-.5.22-.5.5v1.25a.5.5 0 0 1-1 0V7.5c0-1.1.9-2 2-2h.25c.53 0 1.02.21 1.38.57.36.36.57.85.57 1.38v.25c0 .42-.34.76-.76.76z"/>
                                        </svg>
                                        Tidak ada permintaan pembatalan yang menunggu konfirmasi.
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
        </div>
        <div class="card-footer text-end bg-light py-3 rounded-bottom-4">
             <a href="/admin/dashboard" class="btn btn-outline-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door-fill me-1" viewBox="0 0 16 16">
                    <path d="M6.5 14.5v-3.5h3v3.5h4V7.5L8 3.5 2.5 7.5v7h4z"/>
                </svg>
                Kembali
             </a>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Inisialisasi Tooltip Bootstrap (Opsional, tapi bagus untuk Aksi)
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>

</body>
</html>