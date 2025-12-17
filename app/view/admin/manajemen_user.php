<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manajemen User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASEURL ?>/assets/css/warek_dashboard.css" />
    <style>
        :root {
            --primary: #3b82f6;
            --dark-card: linear-gradient(135deg, #4979B7, #6FA8D1);
            --text: #e5e7eb;
            --muted: #9ca3af;
        }

        body {
            background: #F0EFEB;
            color: var(--text);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            width: 240px;
            background: linear-gradient(135deg, #4979B7, #6FA8D1);
            min-height: 100vh;
            padding: 20px;
            position: fixed;
        }

        .sidebar h4 {
            color: #fff;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            color: var(--muted);
            padding: 10px 12px;
            border-radius: 8px;
            text-decoration: none;
            margin-bottom: 6px;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background: var(--primary);
            color: #fff;
        }

        .main {
            margin-left: 260px;
            padding: 30px;
        }

        .card {
            background: var(--dark-card);
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .35);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid #1f2933;
            font-weight: 600;
        }

        .form-control,
        .form-select {
            background: #A6B1A9;
            border: 1px solid #1f2937;
            color: #fff;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: none;
            background: #020617;
            color: #621111ff;
        }

        table {
            color: var(--text);
        }

        thead {
            background: #020617;
        }

        thead th {
            color: var(--muted);
            font-weight: 500;
            border-bottom: 1px solid #1f2937;
        }

        tbody tr {
            border-bottom: 1px solid #1f2937;
        }

        tbody tr:hover {
            background: #020617;
        }

        .btn-primary {
            background: var(--primary);
            border: none;
        }

        .btn-warning {
            background: #f59e0b;
            border: none;
            color: #000;
        }

        .btn-danger {
            background: #ef4444;
            border: none;
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h4>MyRoom</h4>
        <a href="/admin/dashboard">Dashboard</a>
        <a href="/admin/user" class="active">Manajemen User</a>
        <a href="/admin/logout">Logout</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main">
        <h2 class="mb-4">Manajemen User</h2>

        <!-- FORM -->
        <div class="card mb-4">
            <div class="card-header">Tambah / Edit User</div>
            <div class="card-body">
                <form action="/admin/manajemen_user" method="post">
                    <input type="hidden" name="id" id="user_id">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" id="username" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" id="role" class="form-select">
                                <option value="admin">Admin</option>
                                <option value="warek">Warek</option>
                                <option value="peminjam">Peminjam</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" name="action" value="save" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" onclick="resetForm()">Reset</button>
                </form>
            </div>
        </div>

        <!-- TABLE -->
        <div class="card">
            <div class="card-header">Daftar User</div>
            <div class="card-body">
                <table class="table table-borderless align-middle">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['users'] as $u): ?>
                            <tr>
                                <td><?= $u['nama']; ?></td>
                                <td><?= $u['email']; ?></td>
                                <td><?= ucfirst($u['role']); ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="editUser(<?= $u['user_id']; ?>,'<?= $u['nama']; ?>','<?= $u['email']; ?>','<?= $u['role']; ?>')">Edit</button>
                                    <form action="/admin/manajemen_user" method="post" style="display:inline">
                                        <input type="hidden" name="id" value="<?= $u['user_id']; ?>">
                                        <button class="btn btn-danger btn-sm" name="action" value="delete" onclick="return confirm('Hapus user?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function editUser(id, nama, email, role) {
            document.getElementById('user_id').value = id;
            document.getElementById('username').value = nama;
            document.getElementById('email').value = email;
            document.getElementById('role').value = role;
            document.getElementById('password').value = '';
        }

        function resetForm() {
            document.getElementById('user_id').value = '';
            document.getElementById('username').value = '';
            document.getElementById('email').value = '';
            document.getElementById('password').value = '';
            document.getElementById('role').value = 'admin';
        }
    </script>
</body>

</html>