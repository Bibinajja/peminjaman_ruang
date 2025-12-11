<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Peminjaman Ruang</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="icon" type="image/x-icon" href="<?= BASEURL ?>/assets/img/favicon.ico">
</head>

<body>
    <header>
        <nav>
            <div class="nav-container">
                <h1>Sistem Peminjaman Ruang</h1>
                <ul>
                    <?php if (isset($_SESSION['user'])): ?>
                        <?php if ($_SESSION['user']['role'] == 'peminjam'): ?>
                            <li><a href="/peminjam/dashboard">Dashboard</a></li>
                            <li><a href="/peminjam/cek_ketersediaan">Cek Ketersediaan</a></li>
                            <li><a href="/peminjam/form_peminjaman">Form Peminjaman</a></li>
                            <li><a href="/peminjam/riwayat_peminjaman">Riwayat Peminjaman</a></li>
                        <?php elseif ($_SESSION['user']['role'] == 'admin'): ?>
                            <li><a href="/admin/dashboard">Dashboard</a></li>
                            <li><a href="/admin/manajemen_user">Manajemen User</a></li>
                            <li><a href="/admin/manajemen_ruang">Manajemen Ruang</a></li>
                            <li><a href="/admin/konfirmasi_peminjaman">Konfirmasi Peminjaman</a></li>
                            <li><a href="/admin/konfirmasi_pengembalian">Konfirmasi Pengembalian</a></li>
                            <li><a href="/admin/konfirmasi_pembatalan">Konfirmasi Pembatalan</a></li>
                        <?php elseif ($_SESSION['user']['role'] == 'warek'): ?>
                            <li><a href="/warek/dashboard">Dashboard</a></li>
                            <li><a href="/warek/konfirmasi_warek">Konfirmasi Warek</a></li>
                        <?php endif; ?>
                        <li><a href="/logout">Logout</a></li>
                    <?php else: ?>
                        <li><a href="/home">Home</a></li>
                        <li><a href="/login">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>
    <main>