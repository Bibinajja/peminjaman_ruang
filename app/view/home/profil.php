<?php
// session_start();
// // require_once '../../core/Database.php';

// // Cek apakah user sudah login
// if (!isset($_SESSION['user_id'])) {
//     header('Location: login.php');
//     exit();
// }

$db = new Database();
$user_id = $_SESSION['user_id'];

// Ambil data user dari database
$db->query("SELECT user_id, nama, email, role FROM users WHERE user_id = :user_id");
$db->bind(':user_id', $user_id);
$user = $db->single();

// Proses update profil
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($password)) {
        // Update dengan password baru
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $db->query("UPDATE users SET nama = :nama, email = :email, password = :password WHERE user_id = :user_id");
        $db->bind(':nama', $nama);
        $db->bind(':email', $email);
        $db->bind(':password', $hashed_password);
        $db->bind(':user_id', $user_id);
    } else {
        // Update tanpa mengubah password
        $db->query("UPDATE users SET nama = :nama, email = :email WHERE user_id = :user_id");
        $db->bind(':nama', $nama);
        $db->bind(':email', $email);
        $db->bind(':user_id', $user_id);
    }

    $db->execute();

    if ($db->rowCount() > 0) {
        $success_message = "Profil berhasil diperbarui!";
        // Refresh data user
        $db->query("SELECT user_id, nama, email, role FROM users WHERE user_id = :user_id");
        $db->bind(':user_id', $user_id);
        $user = $db->single();
    } else {
        $error_message = "Tidak ada perubahan data atau gagal memperbarui profil!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna - Sistem Peminjaman Ruang</title>
    <link rel="stylesheet" href="../../../public/assets/css/profil.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-brand">Sistem Peminjaman Ruang</div>
        <div class="nav-menu">
            <a href="riwayat_peminjaman.php" class="nav-link">Riwayat Peminjaman</a>
            <a href="../../controller/User.php?action=logout" class="nav-link">Logout</a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Profile Section -->
        <div class="profile-header">
            <div class="avatar">
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="50" cy="50" r="50" fill="#B4C5D9" />
                    <circle cx="50" cy="40" r="18" fill="#fff" />
                    <path d="M 20 85 Q 20 60 50 60 Q 80 60 80 85" fill="#fff" />
                </svg>
            </div>
            <div class="profile-name-section">
                <div class="profile-name"><?php echo htmlspecialchars($user['nama']); ?></div>
                <div class="profile-email"><?php echo htmlspecialchars($user['email']); ?></div>
            </div>
        </div>

        <!-- Information Form -->
        <div class="info-section">
            <h2 class="section-title">Informasi Personal</h2>
            <form method="POST" action="" id="profileForm">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" class="form-input"
                        value="<?php echo htmlspecialchars($user['nama']); ?>" disabled>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-input"
                        value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                </div>

                <div class="form-group" id="passwordGroup" style="display: none;">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-input"
                        placeholder="Kosongkan jika tidak ingin mengubah password" disabled>
                </div>

                <div class="form-actions">
                    <button type="button" id="editBtn" class="btn btn-primary">Edit Profile</button>
                    <button type="submit" name="update_profile" id="saveBtn" class="btn btn-success" style="display: none;">Simpan Perubahan</button>
                    <button type="button" id="cancelBtn" class="btn btn-secondary" style="display: none;">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 Sistem Peminjaman Ruang. All rights reserved.</p>
    </footer>

    <script src="../../../public/assets/js/profil.js"></script>
</body>

</html>