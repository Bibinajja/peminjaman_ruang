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
            background: #f4f6f9;
        }

        .login-container {
            min-height: 100vh;
        }

        .login-card {
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
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

                <h3 class="text-center login-title mb-4">
                    Login Sistem Peminjaman Ruang
                </h3>

                <!-- FORM LOGIN -->
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
                    <a href="<?= BASEURL ?>/peminjam/register">Daftar</a>
                </p>

            </div>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>