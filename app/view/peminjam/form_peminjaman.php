<?php require_once '../templates/header.php'; ?>

<div class="container">
    <h2>Form Peminjaman Ruang</h2>
    <form action="/peminjam/form_peminjaman" method="POST">
        <label for="ruang_id">Pilih Ruang:</label>
        <select id="ruang_id" name="ruang_id" required>
            <?php foreach ($data['ruang'] as $ruang): ?>
                <option value="<?php echo $ruang['ruang_id']; ?>"><?php echo $ruang['nama_ruang']; ?></option>
            <?php endforeach; ?>
        </select>
        <label for="tanggal_mulai">Tanggal Mulai:</label>
        <input type="date" id="tanggal_mulai" name="tanggal_mulai" required>
        <label for="tanggal_selesai">Tanggal Selesai:</label>
        <input type="date" id="tanggal_selesai" name="tanggal_selesai" required>
        <label for="keperluan">Keperluan:</label>
        <textarea id="keperluan" name="keperluan" required></textarea>
        <button type="submit" class="btn">Ajukan Peminjaman</button>
    </form>
</div>

<?php require_once '../templates/footer.php'; ?>