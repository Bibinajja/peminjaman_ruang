<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="../../../public/assets/css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Admin Dashboard</h1>
        <p>Selamat datang di panel admin sistem peminjaman ruang.</p>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manajemen Ruang</h5>
                        <p class="card-text">Kelola ruang dengan operasi CRUD.</p>
                        <a href="/admin/manajemen_ruang" class="btn btn-primary">Kelola Ruang</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manajemen User</h5>
                        <p class="card-text">Kelola pengguna dengan operasi CRUD dan tambah admin.</p>
                        <a href="/admin/manajemen_user" class="btn btn-primary">Kelola User</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Konfirmasi Peminjaman</h5>
                        <p class="card-text">Konfirmasi peminjaman tahap satu.</p>
                        <a href="/admin/konfirmasi_peminjaman" class="btn btn-primary">Konfirmasi</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Konfirmasi Pembatalan</h5>
                        <p class="card-text">Konfirmasi pembatalan peminjaman dengan alasan.</p>
                        <a href="/admin/konfirmasi_pembatalan" class="btn btn-primary">Konfirmasi</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Konfirmasi Pengembalian</h5>
                        <p class="card-text">Konfirmasi pengembalian dengan setuju/tolak.</p>
                        <a href="/admin/konfirmasi_pengembalian" class="btn btn-primary">Konfirmasi</a>
                    </div>
                </div>
            </div>
        </div>
        <a href="/logout" class="btn btn-danger mt-3">Logout</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>