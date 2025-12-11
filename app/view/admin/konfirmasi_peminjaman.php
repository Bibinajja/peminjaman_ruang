<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Konfirmasi Peminjaman Ruang (Tahap 1)</h1>
        <p>Daftar permintaan peminjaman yang perlu dikonfirmasi. Jika ada konflik (2 peminjaman pada tanggal sama), pilih mana yang disetujui.</p>
        <div class="row">
            <?php if (isset($data['peminjaman']) && !empty($data['peminjaman'])): ?>
                <?php foreach ($data['peminjaman'] as $item): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Peminjaman ID: <?php echo $item['id']; ?></h5>
                                <p class="card-text">
                                    Peminjam: <?php echo $item['peminjam']; ?><br>
                                    Ruang: <?php echo $item['ruang']; ?><br>
                                    Tanggal: <?php echo $item['tanggal']; ?><br>
                                    Waktu: <?php echo $item['waktu']; ?><br>
                                    Kegiatan: <?php echo $item['kegiatan']; ?>
                                </p>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-info btn-sm" onclick="showDetail(<?php echo $item['id']; ?>)">Detail</button>
                                    <form action="/admin/konfirmasi_peminjaman" method="post" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                        <button type="submit" name="action" value="approve" class="btn btn-success btn-sm">Setujui</button>
                                        <button type="submit" name="action" value="cancel" class="btn btn-danger btn-sm">Batalkan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p>Tidak ada permintaan peminjaman pending.</p>
                </div>
            <?php endif; ?>
        </div>
        <a href="/admin/dashboard" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>

    <!-- Modal for Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Peminjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="detailContent">
                    <!-- Detail will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showDetail(id) {
            // Assume AJAX to load detail, for now just placeholder
            document.getElementById('detailContent').innerHTML = 'Detail untuk ID: ' + id;
            var modal = new bootstrap.Modal(document.getElementById('detailModal'));
            modal.show();
        }
    </script>
</body>

</html>