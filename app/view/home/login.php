<div class="container">
    <h2>Login</h2>
<<<<<<< Updated upstream
    <?php if (isset($data['error'])): ?>
        <p class="error"><?php echo $data['error']; ?></p>
    <?php endif; ?>
    <form action="<?= BASEURL ?>/home/login_process" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit" class="btn">Login</button>
=======
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Sistem Peminjaman Ruang</title>

        <!-- Bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
            body {
                background: #f4f6f9;
            }

            .login-container {
                height: 100vh;
            }

            .login-card {
                border-radius: 20px;
                padding: 30px;
                box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.1);
                background: #ffffff;
            }

            .login-title {
                font-weight: 700;
                color: #2c3e50;
            }
        </style>
    </head>

    <body>

        <div class="container login-container d-flex justify-content-center align-items-center">
            <div class="col-md-4">
                <div class="login-card">

                    <h3 class="text-center login-title mb-4">Login Sistem Peminjaman Ruang</h3>

                    <form action="../index.php?action=login" method="POST">

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input class="form-control" type="text" name="username" placeholder="Masukkan Username"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input class="form-control" type="password" name="password" placeholder="Masukkan Password"
                                required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Masuk</button>

                    </form>

                </div>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
>>>>>>> Stashed changes
    </form>
    <p>Belum punya akun? <a href="<?= BASEURL ?>/view/peminjam/form_peminjaman">Register</a></p>
</div>