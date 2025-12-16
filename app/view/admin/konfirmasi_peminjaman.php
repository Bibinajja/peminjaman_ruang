<?php
session_start();
require_once '../../core/Database.php'; // Sesuaikan path jika perlu
$db = new Database();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../login.php");
    exit();
}

// Proses aksi
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $status = ($_GET['action'] === 'setujui') ? 'konfirmasi_admin' : 'ditolak';

    $db->query("UPDATE peminjaman SET status = :status WHERE peminjaman_id = :id");
    $db->bind(':status', $status);
    $db->bind(':id', $id);
    $db->execute();

    header("Location: konfirmasi_peminjaman.php");
    exit();
}

// Ambil data
try {
    $db->query("
        SELECT 
            p.peminjaman_id, p.tanggal_mulai, p.tanggal_selesai, p.keperluan, p.status,
            u.nama AS nama_peminjam,
            r.nama_ruang
        FROM peminjaman p
        JOIN users u ON p.user_id = u.user_id
        JOIN ruang r ON p.ruang_id = r.ruang_id
        ORDER BY p.created_at DESC
    ");
    $peminjaman = $db->resultSet();
} catch (Exception $e) {
    $peminjaman = [];
    $error = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Peminjaman - Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"> 

    <link rel="stylesheet" href="../../../public/assets/css/admin-konfirmasi.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <h2 class="logo">MyRoom</h2>

            <ul class="nav-menu" id="navMenu">
                <li><a href="dashboard.php" class="nav-link">Dashboard</a></li>
                <li><a href="ruang.php" class="nav-link">Ruang</a></li>
                <li><a href="user.php" class="nav-link">User</a></li>
                <li><a href="konfirmasi_peminjaman.php" class="nav-link active">Konfirmasi</a></li>
            </ul>

            <div class="nav-right">
                <div class="profile-dropdown" id="profileDropdown">
                    <button class="profile-btn" id="profileBtn">
                        <i class="fas fa-user-shield"></i>
                        Admin
                        <i class="fas fa-chevron-down"></i>
                    </button>

                    <div class="dropdown-menu">
                        <a href="#" class="dropdown-item">Profil</a>
                        <a href="../../logout.php" class="dropdown-item logout">Logout</a>
                    </div>
                </div>

                <div class="hamburger" id="hamburger">
                    <span></span><span></span><span></span>
                </div>
            </div>
        </div>
    </nav>


    <div class="container" style="padding-top: 95px;"> 
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (empty($peminjaman)): ?>
            <div class="alert alert-info text-center py-5">
                <h5>Belum ada permohonan peminjaman ruangan.</h5>
            </div>
        <?php else: ?>
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Pemohon</th>
                                    <th>Ruang</th>
                                    <th>Tanggal Penggunaan</th>
                                    <th>Keperluan</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($peminjaman as $row): ?>
                                    <tr class="table-row-hover">
                                        <td class="text-center fw-medium"><?= $no++ ?></td>
                                        <td class="fw-semibold"><?= htmlspecialchars($row['nama_peminjam']) ?></td>
                                        <td><?= htmlspecialchars($row['nama_ruang']) ?></td>
                                        <td>
                                            <div><?= date('d/m/Y', strtotime($row['tanggal_mulai'])) ?></div>
                                            <small class="text-muted">s.d. <?= date('d/m/Y', strtotime($row['tanggal_selesai'])) ?></small>
                                        </td>
                                        <td class="text-wrap" style="max-width: 250px;">
                                            <?= nl2br(htmlspecialchars($row['keperluan'])) ?>
                                        </td>
                                        <td>
                                            <?php
                                            $status = $row['status'];
                                            $badge = match($status) {
                                                'pending' => ['bg-secondary', 'Menunggu Konfirmasi'],
                                                'konfirmasi_admin' => ['bg-info text-white', 'Menunggu Warek'],
                                                'konfirmasi_warek' => ['bg-primary text-white', 'Konfirmasi Warek'],
                                                'diterima' => ['bg-success text-white', 'Diterima'],
                                                'ditolak' => ['bg-danger text-white', 'Ditolak'],
                                                'dibatalkan' => ['bg-warning text-dark', 'Dibatalkan'],
                                                'selesai' => ['bg-dark text-white', 'Selesai'],
                                                default => ['bg-secondary', ucfirst($status)]
                                            };
                                            ?>
                                            <span class="badge <?= $badge[0] ?> px-3 py-2"><?= $badge[1] ?></span>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($row['status'] === 'pending'): ?>
                                                <a href="?action=setujui&id=<?= $row['peminjaman_id'] ?>"
                                                   class="btn btn-success btn-sm me-1"
                                                   onclick="return confirm('Setujui permohonan ini? Akan dikirim ke Warek.')">
                                                    Setujui
                                                </a>
                                                <a href="?action=tolak&id=<?= $row['peminjaman_id'] ?>"
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('Tolak permohonan ini?')">
                                                    Tolak
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted small">Sudah diproses</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
/* DROPDOWN */
document.getElementById('profileBtn').onclick = () => {
    document.getElementById('profileDropdown').classList.toggle('active');
};

/* HAMBURGER */
document.getElementById('hamburger').onclick = () => {
    document.getElementById('navMenu').classList.toggle('active');
};

/* CLOSE DROPDOWN CLICK OUTSIDE */
document.addEventListener('click', e => {
    if (!e.target.closest('.profile-dropdown')) {
        document.getElementById('profileDropdown').classList.remove('active');
    }
});
</script>

<script src="../../../public/assets/js/admin-konfirmasi.js"></script>

<style>
/* ===== NAVBAR ADMIN (WAREK VERSION) ===== */
.navbar {
    position: fixed;
    top: 0;
    width: 100%;
    background: rgba(255,255,255,0.97);
    backdrop-filter: blur(10px);
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    z-index: 999;
}

.navbar .container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 20px;
}

.logo {
    font-size: 1.8rem;
    font-weight: 700;
    background: linear-gradient(135deg,#4D9AC0,#3B6EA5);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* MENU */
.nav-menu {
    display: flex;
    gap: 1.5rem;
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav-link {
    text-decoration: none;
    color: #2c3e50;
    font-weight: 500;
    padding: 8px 14px;
    border-radius: 8px;
    transition: .3s;
}

.nav-link:hover,
.nav-link.active {
    background: rgba(77,154,192,.15);
    color: #4D9AC0;
}

/* RIGHT */
.nav-right {
    display: flex;
    align-items: center;
    gap: 1rem;
}

/* PROFILE */
.profile-dropdown {
    position: relative;
}

.profile-btn {
    background: linear-gradient(135deg,#4D9AC0,#3B6EA5);
    color: #fff;
    border: none;
    padding: 8px 16px;
    border-radius: 50px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
}

.dropdown-menu {
    position: absolute;
    right: 0;
    top: calc(100% + 10px);
    background: #fff;
    min-width: 200px;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0,0,0,.12);
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: .3s;
    overflow: hidden;
}

.profile-dropdown.active .dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-item {
    display: block;
    padding: 12px 18px;
    color: #2c3e50;
    text-decoration: none;
}

.dropdown-item:hover {
    background: #f5f7fa;
    color: #4D9AC0;
}

.dropdown-item.logout:hover {
    background: #fee;
    color: #e74c3c;
}

/* HAMBURGER */
.hamburger {
    display: none;
    flex-direction: column;
    gap: 4px;
    cursor: pointer;
}

.hamburger span {
    width: 24px;
    height: 3px;
    background: #4D9AC0;
    border-radius: 3px;
}

/* RESPONSIVE */
@media(max-width: 992px){
    .nav-menu {
        position: fixed;
        top: 70px;
        left: -100%;
        flex-direction: column;
        width: 100%;
        background: white;
        padding: 20px 0;
        transition: .3s;
        box-shadow: 0 10px 25px rgba(0,0,0,.1);
    }

    .nav-menu.active {
        left: 0;
    }

    .hamburger {
        display: flex;
    }
}

/* ===== RAPAPIH TABEL ADMIN ===== */
.card {
    border-radius: 14px;
}

.table th {
    white-space: nowrap;
    vertical-align: middle;
}

.table td {
    vertical-align: middle;
}

.table td .badge {
    font-size: .85rem;
}

.table-responsive {
    border-radius: 14px;
    overflow: hidden;
}
</style>

</body>
</html>