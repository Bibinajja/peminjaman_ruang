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
        <h1 class="mb-4">Manajemen Ruang</h1>

        <!-- Form Tambah / Edit Ruang -->
        <div class="card mb-5">
            <div class="card-header bg-primary text-white">
                <strong><?= isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> Ruang</strong>
            </div>
            <div class="card-body">
                <form action="<?= BASEURL ?>/admin/ruang" method="post">
                    <input type="hidden" name="id" id="ruangId" value="">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_ruang" class="form-label">Nama Ruang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama_ruang" name="nama_ruang" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kapasitas" class="form-label">Kapasitas <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="kapasitas" name="kapasitas" min="1" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="lokasi" class="form-label">Lokasi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fasilitas" class="form-label">Fasilitas / Deskripsi</label>
                            <textarea class="form-control" id="fasilitas" name="fasilitas" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" name="action" value="save" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">Batal / Reset</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Daftar Ruang -->
        <h2 class="mb-3">Daftar Ruang</h2>
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Nama Ruang</th>
                        <th>Kapasitas</th>
                        <th>Lokasi</th>
                        <th>Deskripsi / Fasilitas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($data['ruang']) && is_array($data['ruang']) && count($data['ruang']) > 0): ?>
                        <?php $no = 1; foreach ($data['ruang'] as $ruang): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($ruang['ruang_id']) ?></td>
                                <td><?= htmlspecialchars($ruang['nama_ruang']) ?></td>
                                <td><?= htmlspecialchars($ruang['kapasitas']) ?></td>
                                <td><?= htmlspecialchars($ruang['lokasi']) ?></td>
                                <td><?= htmlspecialchars($ruang['deskripsi'] ?? '-') ?></td>
                                <td>
                                    <span class="badge bg-<?= $ruang['status'] === 'aktif' ? 'success' : 'secondary' ?>">
                                        <?= ucfirst(htmlspecialchars($ruang['status'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm" onclick="editRuang(
                                        <?= $ruang['ruang_id'] ?>,
                                        '<?= addslashes(htmlspecialchars($ruang['nama_ruang'])) ?>',
                                        <?= $ruang['kapasitas'] ?>,
                                        '<?= addslashes(htmlspecialchars($ruang['lokasi'])) ?>',
                                        '<?= addslashes(htmlspecialchars($ruang['deskripsi'] ?? '')) ?>'
                                    )">Edit</button>

                                    <form action="<?= BASEURL ?>/admin/ruang" method="post" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= $ruang['ruang_id'] ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('Yakin ingin menghapus ruang <?= addslashes(htmlspecialchars($ruang['nama_ruang'])) ?>?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center py-4">Belum ada data ruang.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <a href="<?= BASEURL ?>/admin/dashboard" class="btn btn-outline-primary mt-3">← Kembali ke Dashboard</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editRuang(id, nama_ruang, kapasitas, lokasi, deskripsi) {
            document.getElementById('ruangId').value = id;
            document.getElementById('nama_ruang').value = nama_ruang;
            document.getElementById('kapasitas').value = kapasitas;
            document.getElementById('lokasi').value = lokasi;
            document.getElementById('fasilitas').value = deskripsi || '';

            // Optional: scroll ke atas form
            document.querySelector('.card-header').scrollIntoView({ behavior: 'smooth' });
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