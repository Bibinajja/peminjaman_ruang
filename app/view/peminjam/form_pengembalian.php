<?php require_once '../templates/header.php'; ?>

<div class="container">
    <h2>Form Pengembalian Ruang</h2>
    <form action="/peminjam/form_pengembalian" method="POST" enctype="multipart/form-data">
        <label for="peminjaman_id">Pilih Peminjaman:</label>
        <select id="peminjaman_id" name="peminjaman_id" required>
            <?php foreach ($data['peminjaman'] as $peminjaman): ?>
                <?php if ($peminjaman['status'] == 'diterima'): ?>
                    <option value="<?php echo $peminjaman['peminjaman_id']; ?>">
                        <?php echo $peminjaman['nama_ruang'] . ' - ' . $peminjaman['tanggal_mulai'] . ' to ' . $peminjaman['tanggal_selesai']; ?>
                    </option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <label for="tanggal_pengembalian">Tanggal Pengembalian:</label>
        <input type="date" id="tanggal_pengembalian" name="tanggal_pengembalian" required>
        <label for="bukti_kegiatan">Upload Bukti Kegiatan:</label>
        <input type="file" id="bukti_kegiatan" name="bukti_kegiatan" accept="image/*" required>
        <button type="submit" class="btn">Ajukan Pengembalian</button>
    </form>
</div>

<?php require_once '../templates/footer.php'; ?>