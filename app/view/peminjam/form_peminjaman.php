<?php

$ruang_id = $data['ruang_id'] ?? '';
$ruangan  = $data['ruangan'];
$tanggal  = $data['tanggal'] ?? date('Y-m-d');
$ruangDipilih = $data['ruangDipilih'] ?? null;

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Peminjaman Ruangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASEURL ?>/assets/css/form_peminjaman.css">
</head>

<body>

    <div class="container">
        <div class="form-container">
            <h2 class="form-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-calendar-check-fill me-2" viewBox="0 0 16 16">
                    <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zm-5.146-5.146l-3 3-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708z" />
                </svg>
                Formulir Peminjaman Ruangan
            </h2>

            <?php if (isset($_GET['error']) && $_GET['error'] === 'konflik'): ?>
                <div class="alert alert-danger">
                    <strong>Maaf!</strong> Ruangan sudah dipesan pada waktu tersebut. Silakan pilih waktu/ruang lain.
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error']) && $_GET['error'] === 'gagal'): ?>
                <div class="alert alert-danger">
                    <strong>Gagal!</strong> Terjadi kesalahan saat menyimpan data. Silakan coba lagi.
                </div>
            <?php endif; ?>

            <form action="<?= BASEURL ?>/peminjam/peminjaman_process" method="POST">

                <div class="mb-3">
                    <label for="namaPeminjam" class="form-label">Nama Peminjam</label>
                    <input type="text" class="form-control" id="namaPeminjam" name="nama_peminjam" placeholder="Masukkan nama lengkap Anda" required>
                </div>

                <div class="mb-3">
                    <label for="namaRuang" class="form-label">Nama Ruangan</label>
                    <select name="ruang_id" class="form-select" required>
                        <option value="">Pilih Ruangan</option>
                        <?php foreach ($ruangan as $r): ?>
                            <option value="<?= $r['ruang_id'] ?>"
                                <?= ($ruang_id == $r['ruang_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($r['nama_ruang']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Waktu Mulai</label>
                        <div class="input-group">
                            <input type="date" class="form-control" id="tanggalMulai" name="tanggal_mulai"
                                value="<?= $tanggal ?>" required>
                            <input type="time" class="form-control" id="jamMulai" name="jam_mulai" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Waktu Selesai</label>
                        <div class="input-group">
                            <input type="date" class="form-control" id="tanggalSelesai" name="tanggal_selesai" required>
                            <input type="time" class="form-control" id="jamSelesai" name="jam_selesai" required>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="keperluan" class="form-label">Keperluan Peminjaman</label>
                    <textarea class="form-control" id="keperluan" name="keperluan" rows="3"
                        placeholder="Jelaskan secara singkat dan jelas keperluan Anda meminjam ruangan (misalnya: Rapat Koordinasi Tim Marketing)" required></textarea>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-send-check-fill me-2" viewBox="0 0 16 16">
                            <path d="M15.964.686A.5.5 0 0 0 15.5 0H.5a.5.5 0 0 0-.496.562l1.5 8.71a.5.5 0 0 0 .979.091L10H.5a.5.5 0 0 0-.022 1L8 14.945l5.592-7.172a.5.5 0 0 0-.256-.75l-4.223-2.09.734-.41z" />
                            <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0zm-1.993-1.679a.5.5 0 0 0-.616.096l-1.5 1.5a.5.5 0 0 0 0 .708l1 1a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.706L13 13.045l1.354-1.354a.5.5 0 0 0-.096-.616z" />
                        </svg>
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>