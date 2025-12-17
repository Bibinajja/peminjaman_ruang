<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna - MyRoom</title>
    <link rel="stylesheet" href="<?= BASEURL ?>/assets/css/profil.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

    <nav class="navbar">
        <div class="nav-brand">MyRoom</div>
        <div class="nav-menu">
            <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'admin'): ?>
                <a href="<?= BASEURL ?>/admin" class="nav-link">
                    <i class="fas fa-arrow-left"></i> Dashboard
                </a>
            <?php else: ?>
                <a href="<?= BASEURL ?>/home" class="nav-link">
                    <i class="fas fa-home"></i> Home
                </a>
            <?php endif; ?>

            <a href="<?= BASEURL ?>/admin/logout" class="nav-link">Logout</a>
        </div>
    </nav>

    <div class="container">

        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] == 'success'): ?>
                <div class="alert alert-success">Data berhasil diperbarui!</div>
            <?php elseif ($_GET['status'] == 'failed'): ?>
                <div class="alert alert-error">Gagal memperbarui data.</div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="profile-header">
            <div class="avatar">
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <rect width="100" height="100" fill="#9BB8D3" />
                    <circle cx="50" cy="40" r="20" fill="#fff" />
                    <path d="M 20 90 Q 50 50 80 90" fill="#fff" />
                </svg>
            </div>
            <div class="profile-name-section">
                <div class="profile-label"><?= isset($data['user']['role']) ? strtoupper($data['user']['role']) : 'USER'; ?></div>
                <div class="profile-name"><?= htmlspecialchars($data['user']['nama']); ?></div>
            </div>
        </div>

        <div class="info-section">
            <h2 class="section-title">Informasi Personal</h2>

            <form action="<?= BASEURL ?>/user/update_profil" method="POST" id="profileForm">

                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" class="form-input"
                        value="<?= htmlspecialchars($data['user']['nama']); ?>" disabled required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-input"
                        value="<?= htmlspecialchars($data['user']['email']); ?>" disabled required>
                </div>

                <div class="form-group" id="passwordGroup" style="display: none;">
                    <label for="password">Password Baru <small>(Kosongkan jika tidak ubah)</small></label>
                    <input type="password" id="password" name="password" class="form-input"
                        placeholder="Masukkan password baru" disabled>
                </div>

                <div class="form-actions">
                    <button type="button" id="editBtn" class="btn btn-primary">Edit Profil</button>
                    <button type="submit" id="saveBtn" class="btn btn-success" style="display: none;">Simpan</button>
                    <button type="button" id="cancelBtn" class="btn btn-secondary" style="display: none;">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2024 MyRoom - Sistem Peminjaman Ruang</p>
    </footer>

    <script>
        const editBtn = document.getElementById('editBtn');
        const saveBtn = document.getElementById('saveBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const inputs = document.querySelectorAll('.form-input');
        const passwordGroup = document.getElementById('passwordGroup');
        const passwordInput = document.getElementById('password');

        // Simpan nilai asli untuk tombol Batal
        let originalValues = {};

        editBtn.addEventListener('click', () => {
            // Simpan nilai saat ini sebelum diedit
            inputs.forEach(input => {
                if (input.id !== 'password') {
                    originalValues[input.id] = input.value;
                }
                input.removeAttribute('disabled');
            });

            // Tampilkan field password & tombol aksi
            passwordGroup.style.display = 'block';
            passwordInput.removeAttribute('disabled');

            editBtn.style.display = 'none';
            saveBtn.style.display = 'inline-block';
            cancelBtn.style.display = 'inline-block';
        });

        cancelBtn.addEventListener('click', () => {
            // Kembalikan nilai ke semula
            inputs.forEach(input => {
                if (input.id !== 'password') {
                    input.value = originalValues[input.id];
                }
                input.setAttribute('disabled', true);
            });

            // Sembunyikan field password & reset isinya
            passwordGroup.style.display = 'none';
            passwordInput.setAttribute('disabled', true);
            passwordInput.value = '';

            // Kembalikan tombol ke kondisi awal
            editBtn.style.display = 'inline-block';
            saveBtn.style.display = 'none';
            cancelBtn.style.display = 'none';
        });
    </script>
</body>

</html>