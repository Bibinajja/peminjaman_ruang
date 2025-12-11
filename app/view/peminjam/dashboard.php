<?php require_once '../templates/header.php'; ?>

<div class="container">
    <h2>Dashboard Peminjam</h2>
    <p>Selamat datang, <?php echo $_SESSION['user']['nama']; ?>!</p>
    <div class="stats">
        <div class="stat">
            <h3>Peminjaman Aktif</h3>
            <p><?php echo $data['active_count'] ?? 0; ?></p>
        </div>
        <div class="stat">
            <h3>Riwayat Peminjaman</h3>
            <p><?php echo $data['history_count'] ?? 0; ?></p>
        </div>
    </div>
    <div class="actions">
        <a href="/peminjam/cek_ketersediaan" class="btn">Cek Ketersediaan Ruang</a>
        <a href="/peminjam/form_peminjaman" class="btn">Ajukan Peminjaman</a>
        <a href="/peminjam/riwayat_peminjaman" class="btn">Riwayat Peminjaman</a>
        <a href="/peminjam/form_pembatalan" class="btn">Pembatalan Peminjaman</a>
        <a href="/peminjam/form_pengembalian" class="btn">Pengembalian Ruang</a>
    </div>
</div>

<?php require_once '../templates/footer.php'; ?>