<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Ruang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Manajemen Ruang</h1>
        <p>Kelola ruang dengan operasi CRUD (Create, Read, Update, Delete).</p>

        <!-- Add/Edit Form -->
        <div class="card mb-4">
            <div class="card-header">
                Tambah/Edit Ruang
            </div>
            <div class="card-body">
                <form action="/admin/manajemen_ruang" method="post">
                    <input type="hidden" name="id" id="ruangId" value="">
                    <div class="mb-3">
                        <label for="nama_ruang" class="form-label">Nama Ruang:</label>
                        <input type="text" class="form-control" id="nama_ruang" name="nama_ruang" required>
                    </div>
                    <div class="mb-3">
                        <label for="kapasitas" class="form-label">Kapasitas:</label>
                        <input type="number" class="form-control" id="kapasitas" name="kapasitas" required>
                    </div>
                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi:</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi" required>
                    </div>
                    <div class="mb-3">
                        <label for="fasilitas" class="form-label">Fasilitas:</label>
                        <textarea class="form-control" id="fasilitas" name="fasilitas"></textarea>
                    </div>
                    <button type="submit" name="action" value="save" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" onclick="resetForm()">Reset</button>
                </form>
            </div>
        </div>

        <!-- List of Rooms -->
        <h2>Daftar Ruang</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Ruang</th>
                    <th>Kapasitas</th>
                    <th>Lokasi</th>
                    <th>Fasilitas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($data['ruang']) && !empty($data['ruang'])): ?>
                    <?php foreach ($data['ruang'] as $ruang): ?>
                        <tr>
                            <td><?php echo $ruang['id']; ?></td>
                            <td><?php echo $ruang['nama_ruang']; ?></td>
                            <td><?php echo $ruang['kapasitas']; ?></td>
                            <td><?php echo $ruang['lokasi']; ?></td>
                            <td><?php echo $ruang['fasilitas']; ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editRuang(<?php echo $ruang['id']; ?>, '<?php echo $ruang['nama_ruang']; ?>', <?php echo $ruang['kapasitas']; ?>, '<?php echo $ruang['lokasi']; ?>', '<?php echo $ruang['fasilitas']; ?>')">Edit</button>
                                <form action="/admin/manajemen_ruang" method="post" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $ruang['id']; ?>">
                                    <button type="submit" name="action" value="delete" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Tidak ada ruang.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="/admin/dashboard" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editRuang(id, nama_ruang, kapasitas, lokasi, fasilitas) {
            document.getElementById('ruangId').value = id;
            document.getElementById('nama_ruang').value = nama_ruang;
            document.getElementById('kapasitas').value = kapasitas;
            document.getElementById('lokasi').value = lokasi;
            document.getElementById('fasilitas').value = fasilitas;
        }

        function resetForm() {
            document.getElementById('ruangId').value = '';
            document.getElementById('nama_ruang').value = '';
            document.getElementById('kapasitas').value = '';
            document.getElementById('lokasi').value = '';
            document.getElementById('fasilitas').value = '';
        }
    </script>
</body>

</html>