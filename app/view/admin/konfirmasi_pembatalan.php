<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembatalan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Konfirmasi Pembatalan Peminjaman</h1>
        <p>Daftar permintaan pembatalan peminjaman dengan alasan dari peminjam.</p>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Peminjaman</th>
                    <th>Peminjam</th>
                    <th>Ruang</th>
                    <th>Tanggal</th>
                    <th>Alasan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($data['pembatalan']) && !empty($data['pembatalan'])): ?>
                    <?php foreach ($data['pembatalan'] as $item): ?>
                        <tr>
                            <td><?php echo $item['id']; ?></td>
                            <td><?php echo $item['peminjam']; ?></td>
                            <td><?php echo $item['ruang']; ?></td>
                            <td><?php echo $item['tanggal']; ?></td>
                            <td><?php echo $item['alasan']; ?></td>
                            <td>
                                <form action="/admin/konfirmasi_pembatalan" method="post" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                    <button type="submit" name="action" value="confirm" class="btn btn-success btn-sm">Konfirmasi</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Tidak ada permintaan pembatalan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="/admin/dashboard" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>