<?php require_once '../templates/header.php'; ?>

<div class="container">
    <h2>Form Pembatalan Peminjaman</h2>
    <form action="/peminjam/form_pembatalan" method="POST">
        <label for="peminjaman_id">Pilih Peminjaman:</label>
        <select id="peminjaman_id" name="peminjaman_id" required>
            <?php foreach ($data['peminjaman'] as $peminjaman): ?>
                <?php if (in_array($peminjaman['status'], ['pending', 'konfirmasi_admin', 'konfirmasi_warek'])): ?>
                    <option value="<?php echo $peminjaman['peminjaman_id']; ?>">
                        <?php echo $peminjaman['nama_ruang'] . ' - ' . $peminjaman['tanggal_mulai'] . ' to ' . $peminjaman['tanggal_selesai']; ?>
                    </option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <label for="alasan_pembatalan">Alasan Pembatalan:</label>
        <textarea id="alasan_pembatalan" name="alasan_pembatalan" required></textarea>
        <button type="submit" class="btn">Ajukan Pembatalan</button>
    </form>
</div>

<?php require_once '../templates/footer.php'; ?>