<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pengembalian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Konfirmasi Pengembalian Peminjaman</h1>
        <p>Daftar permintaan pengembalian dengan alasan dari peminjam. Setujui atau tolak dengan alasan jika ditolak.</p>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Peminjaman</th>
                    <th>Peminjam</th>
                    <th>Ruang</th>
                    <th>Tanggal</th>
                    <th>Alasan Pengembalian</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($data['pengembalian']) && !empty($data['pengembalian'])): ?>
                    <?php foreach ($data['pengembalian'] as $item): ?>
                        <tr>
                            <td><?php echo $item['id']; ?></td>
                            <td><?php echo $item['peminjam']; ?></td>
                            <td><?php echo $item['ruang']; ?></td>
                            <td><?php echo $item['tanggal']; ?></td>
                            <td><?php echo $item['alasan']; ?></td>
                            <td>
                                <form action="/admin/konfirmasi_pengembalian" method="post" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                    <button type="submit" name="action" value="approve" class="btn btn-success btn-sm">Setujui</button>
                                    <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal<?php echo $item['id']; ?>">Tolak</button>
                                </form>
                            </td>
                        </tr>
                        <!-- Modal for Reject Reason -->
                        <div class="modal fade" id="rejectModal<?php echo $item['id']; ?>" tabindex="-1" aria-labelledby="rejectModalLabel<?php echo $item['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="rejectModalLabel<?php echo $item['id']; ?>">Alasan Penolakan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="/admin/konfirmasi_pengembalian" method="post">
                                        <!-- gpt
                                     <form action="<?= BASEURL ?>/admin/proses_pengembalian" method="post"> -->
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                            <input type="hidden" name="action" value="reject">
                                            <div class="mb-3">
                                                <label for="reason<?php echo $item['id']; ?>" class="form-label">Alasan Penolakan:</label>
                                                <textarea class="form-control" id="reason<?php echo $item['id']; ?>" name="reason" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Tolak</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Tidak ada permintaan pengembalian.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="/admin/dashboard" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>