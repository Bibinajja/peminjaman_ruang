<?php require_once '../templates/header.php'; ?>

<div class="container">
    <h2>Dashboard Warek</h2>
    <p>Selamat datang, <?php echo $_SESSION['user']['nama']; ?>!</p>
    <div class="stats">
        <div class="stat">
            <h3>Total Peminjaman Pending</h3>
            <p><?php echo $data['pending_count'] ?? 0; ?></p>
        </div>
        <div class="stat">
            <h3>Total Peminjaman Dikonfirmasi</h3>
            <p><?php echo $data['confirmed_count'] ?? 0; ?></p>
        </div>
    </div>
    <div class="actions">
        <a href="/warek/konfirmasi_warek" class="btn">Konfirmasi Peminjaman</a>
    </div>
</div>

<?php require_once '../templates/footer.php'; ?>