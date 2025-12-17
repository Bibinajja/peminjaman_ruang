<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sistem Peminjaman Ruang</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-wrapper {
            height: 100vh;
            display: flex;
        }

        /* SIDEBAR PUTIH */
        .login-sidebar {
            flex: 4;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            border-right: 1px solid #e5e7eb;
        }

        .sidebar-content {
            text-align: center;
            padding: 40px;
            color: #2c3e50;
        }

        .sidebar-content img {
            width: 400px;
            margin-bottom: 20px;
        }

        .sidebar-content h2 {
            font-weight: 700;
            color: #0d6efd;
        }

        .sidebar-content p {
            color: #6c757d;
        }

        /* FORM BIRU */
        .login-content {
            flex: 6;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0d6efd, #0b5ed7);
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        .login-title {
            font-weight: 700;
            color: #0d6efd;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px 14px;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .btn-primary {
            border-radius: 10px;
            padding: 10px;
            font-weight: 600;
        }

        .login-card a {
            color: #0d6efd;
            font-weight: 600;
            text-decoration: none;
        }

        .login-card a:hover {
            text-decoration: underline;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .login-sidebar {
                display: none;
            }

            .login-content {
                flex: 1;
            }
        }
    </style>
</head>

<body>

    <div class="login-wrapper">

        <!-- SIDEBAR PUTIH -->
        <div class="login-sidebar">
            <div class="sidebar-content">
                <img src="<?= BASEURL ?>/assets/img/LOGO_SISTEM.png" alt="Logo Sistem">

                <p>Sistem Peminjaman Ruang<br>ITS Mandala</p>
            </div>
        </div>

        <!-- FORM BIRU -->
        <div class="login-content">
            <div class="login-card">

                <h4 class="text-center login-title mb-4">
                    Login Sistem
                </h4>

                <form action="<?= BASEURL ?>/home/auth" method="POST">

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="Masukkan Email"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Masukkan Password"
                            required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Masuk
                    </button>

                </form>

                <p class="text-center mt-3">
                    Belum punya akun?
                    <a href="<?= BASEURL ?>/home/register">Daftar</a>
                </p>

            </div>
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>