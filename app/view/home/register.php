<?php
session_start();

// Include database connection
require_once '../../core/Database.php';

// Initialize response variables
$error = '';
$success = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get form data
        $nama = trim($_POST['nama'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirmPassword'] ?? '';
        $terms = isset($_POST['terms']);

        // Validation
        if (empty($nama)) {
            throw new Exception('Nama lengkap harus diisi');
        }

        if (strlen($nama) < 3) {
            throw new Exception('Nama minimal 3 karakter');
        }

        if (strlen($nama) > 100) {
            throw new Exception('Nama maksimal 100 karakter');
        }

        if (!preg_match('/^[a-zA-Z\s]+$/', $nama)) {
            throw new Exception('Nama hanya boleh berisi huruf');
        }

        if (empty($email)) {
            throw new Exception('Email harus diisi');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Format email tidak valid');
        }

        if (strlen($email) > 120) {
            throw new Exception('Email maksimal 120 karakter');
        }

        if (empty($password)) {
            throw new Exception('Password harus diisi');
        }

        if (strlen($password) < 8) {
            throw new Exception('Password minimal 8 karakter');
        }

        if ($password !== $confirmPassword) {
            throw new Exception('Password dan konfirmasi password tidak cocok');
        }

        if (!$terms) {
            throw new Exception('Anda harus menyetujui syarat & ketentuan');
        }

        // Create database connection
        $database = new Database();
        $conn = $database->getConnection();


        // Check if email already exists
        $checkEmailQuery = "SELECT user_id FROM users WHERE email = :email";
        $checkStmt = $conn->prepare($checkEmailQuery);
        $checkStmt->bindParam(':email', $email, PDO::PARAM_STR);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            throw new Exception('Email sudah terdaftar. Silakan gunakan email lain.');
        }

        // Set default role as 'peminjam' (security: no user input for role)
        $role = 'peminjam';

        // Insert new user (password disimpan langsung tanpa hashing untuk pemula)
        $insertQuery = "INSERT INTO users (nama, email, password, role, created_at) 
                        VALUES (:nama, :email, :password, :role, NOW())";
        
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bindParam(':nama', $nama, PDO::PARAM_STR);
        $insertStmt->bindParam(':email', $email, PDO::PARAM_STR);
        $insertStmt->bindParam(':password', $password, PDO::PARAM_STR);
        $insertStmt->bindParam(':role', $role, PDO::PARAM_STR);

        if ($insertStmt->execute()) {
            $success = 'Registrasi berhasil! Silakan login dengan akun Anda.';
            // Redirect to login after 2 seconds
            header("refresh:2;url=login.php");
        } else {
            throw new Exception('Gagal menyimpan data. Silakan coba lagi.');
        }

    } catch (Exception $e) {
        $error = $e->getMessage();
    } catch (PDOException $e) {
        $error = 'Terjadi kesalahan database. Silakan coba lagi.';
        error_log('Registration Error: ' . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - MyRoom</title>
    <link rel="stylesheet" href="../../../public/assets/css/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="register-container">
        <!-- Left Side - Branding -->
        <div class="register-left">
            <div class="brand-content">
                <div class="brand-logo">
                    <i class="fas fa-door-open"></i>
                </div>
                <h1 class="brand-title">MyRoom</h1>
                <p class="brand-subtitle">Sistem Peminjaman Ruang ITS Mandala</p>
                <div class="brand-features">
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Proses Cepat & Mudah</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Real-time Ketersediaan</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Notifikasi Otomatis</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Paperless & Efisien</span>
                    </div>
                </div>
                <div class="brand-decoration">
                    <div class="deco-circle circle-1"></div>
                    <div class="deco-circle circle-2"></div>
                    <div class="deco-circle circle-3"></div>
                </div>
            </div>
        </div>

        <!-- Right Side - Register Form -->
        <div class="register-right">
            <div class="register-card">
                <!-- Back Button -->
                <a href="index.php" class="back-btn">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>

                <!-- Form Header -->
                <div class="form-header">
                    <h2 class="form-title">Buat Akun Baru</h2>
                    <p class="form-subtitle">Daftar untuk menggunakan layanan MyRoom</p>
                </div>

                <!-- Error Message -->
                <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?= htmlspecialchars($error) ?></span>
                </div>
                <?php endif; ?>

                <!-- Success Message -->
                <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span><?= htmlspecialchars($success) ?></span>
                </div>
                <?php endif; ?>

                <!-- Register Form -->
                <form id="registerForm" class="register-form" method="POST" action="">
                    
                    <!-- Nama Lengkap -->
                    <div class="form-group">
                        <label for="nama" class="form-label">
                            <i class="fas fa-user"></i>
                            Nama Lengkap
                        </label>
                        <input 
                            type="text" 
                            id="nama" 
                            name="nama" 
                            class="form-input" 
                            placeholder="Masukkan nama lengkap"
                            maxlength="100"
                            value="<?= isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : '' ?>"
                            required>
                        <span class="error-message" id="namaError"></span>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i>
                            Email
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-input" 
                            placeholder="nama@example.com"
                            maxlength="120"
                            value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
                            required>
                        <span class="error-message" id="emailError"></span>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock"></i>
                            Password
                        </label>
                        <div class="password-wrapper">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="form-input" 
                                placeholder="Minimal 8 karakter"
                                required>
                            <button type="button" class="toggle-password" onclick="togglePassword('password')">
                                <i class="fas fa-eye" id="togglePasswordIcon"></i>
                            </button>
                        </div>
                        <span class="error-message" id="passwordError"></span>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="confirmPassword" class="form-label">
                            <i class="fas fa-lock"></i>
                            Konfirmasi Password
                        </label>
                        <div class="password-wrapper">
                            <input 
                                type="password" 
                                id="confirmPassword" 
                                name="confirmPassword" 
                                class="form-input" 
                                placeholder="Ulangi password"
                                required>
                            <button type="button" class="toggle-password" onclick="togglePassword('confirmPassword')">
                                <i class="fas fa-eye" id="toggleConfirmIcon"></i>
                            </button>
                        </div>
                        <span class="error-message" id="confirmPasswordError"></span>
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="form-group checkbox-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="terms" name="terms" required>
                            <span class="checkbox-custom"></span>
                            <span class="checkbox-text">
                                Saya menyetujui <a href="#" class="link">Syarat & Ketentuan</a> 
                                dan <a href="#" class="link">Kebijakan Privasi</a>
                            </span>
                        </label>
                        <span class="error-message" id="termsError"></span>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-user-plus"></i>
                        <span>Daftar Sekarang</span>
                    </button>

                    <!-- Divider -->
                    <div class="divider">
                        <span>atau</span>
                    </div>

                    <!-- Login Link -->
                    <div class="form-footer">
                        <p class="footer-text">
                            Sudah punya akun?
                            <a href="login.php" class="login-link">Masuk di sini</a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Copyright -->
            <div class="copyright">
                <p>&copy; 2024 MyRoom - ITS Mandala. All rights reserved.</p>
            </div>
        </div>
    </div>

    <script src="../../../public/assets/js/register.js"></script>
</body>
</html>