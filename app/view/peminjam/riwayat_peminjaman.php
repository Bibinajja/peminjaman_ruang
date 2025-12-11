<?php require_once '../templates/header.php'; ?>

<div class="container">
    <h2>Riwayat Peminjaman</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Ruang</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['peminjaman'] as $peminjaman): ?>
                <tr>
                    <td><?php echo $peminjaman['nama_ruang']; ?></td>
                    <td><?php echo $peminjaman['tanggal_mulai']; ?></td>
                    <td><?php echo $peminjaman['tanggal_selesai']; ?></td>
                    <td><?php echo $peminjaman['status']; ?></td>
                    <td>
                        <?php if ($peminjaman['status'] == 'diterima'): ?>
                            <a href="/peminjam/pengembalian/<?php echo $peminjaman['peminjaman_id']; ?>" class="btn">Kembalikan</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once '../templates/footer.php'; ?>