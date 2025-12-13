<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pembatalan Peminjaman Ruangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <style>
        body {
            background-color: #f8f9fa; /* Latar belakang abu-abu muda */
        }
        .form-container {
            max-width: 700px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            /* Garis merah di sisi kiri untuk menunjukkan Pembatalan/Danger */
            border-left: 5px solid #dc3545; 
        }
        .form-header {
            margin-bottom: 25px;
            text-align: center;
            /* Warna merah untuk header */
            color: #dc3545; 
        }
        .form-control:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
        }
        .btn-danger { /* Menggunakan kelas btn-danger (merah) */
            background-color: #dc3545;
            border-color: #dc3545;
            transition: background-color 0.3s ease;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2 class="form-header">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-octagon-fill me-2" viewBox="0 0 16 16">
                <path d="M11.46.292c.843-.794 2.022-.794 2.864 0l1.248 1.157c.394.364.67.873.743 1.41l.245 1.772c.1.724.1 1.488 0 2.212l-.245 1.772c-.073.537-.349 1.046-.743 1.41l-1.248 1.157c-.842.794-2.021.794-2.864 0l-1.248-1.157c-.394-.364-.67-.873-.743-1.41l-.245-1.772c-.1-.724-.1-1.488 0-2.212l.245-1.772c.073-.537.349-1.046.743-1.41l1.248-1.157zM8 12.146l3.354-3.354L12.146 8l-3.354-3.354L8 3.854l-3.354 3.354L3.854 8l3.354 3.354L8 12.146z"/>
            </svg>
            Formulir Pembatalan Peminjaman Ruangan
        </h2>
        
        <form id="formPembatalan">
            <div class="mb-3">
                <label for="namaPeminjam" class="form-label">Nama Peminjam</label>
                <input type="text" class="form-control" id="namaPeminjam" placeholder="Masukkan nama lengkap Anda" required>
            </div>

            <div class="mb-3">
                <label for="namaRuang" class="form-label">Nama Ruangan yang Dibatalkan</label>
                <select class="form-select" id="namaRuang" required>
                    <option selected disabled value="">Pilih Ruangan yang ingin dibatalkan...</option>
                    <option value="AULA-BESAR">Aula Besar Serbaguna</option>
                    <option value="R-MEETING">Ruang Rapat Utama</option>
                    <option value="LAB-KOM">Laboratorium Komputer</option>
                    <option value="R-KULIAH-301">Ruang Kuliah 301</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="waktuDibuat" class="form-label">Waktu Permintaan Pembatalan Dibuat</label>
                <input type="datetime-local" class="form-control" id="waktuDibuat" readonly>
                <div class="form-text">Tanggal dan waktu ini dicatat saat formulir dibuka.</div>
            </div>

            <div class="mb-4">
                <label for="alasan" class="form-label">Alasan Pembatalan Peminjaman</label>
                <textarea class="form-control" id="alasan" rows="3" placeholder="Jelaskan alasan Anda membatalkan peminjaman (misalnya: Acara ditunda/dibatalkan, Salah jadwal input)" required></textarea>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-danger btn-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill me-2" viewBox="0 0 16 16">
                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 2h4l-.49 1H5.99l-.49-1zM5 5v7h6V5z"/>
                    </svg>
                    Konfirmasi Pembatalan
                </button>
            </div>
        </form>
        
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<script>
    // JavaScript untuk mengisi kolom Waktu Dibuat secara otomatis
    document.addEventListener('DOMContentLoaded', function() {
        const waktuDibuatInput = document.getElementById('waktuDibuat');
        const now = new Date();
        
        // Format tanggal dan waktu menjadi format yang diterima oleh input datetime-local (YYYY-MM-DDTHH:MM)
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        
        const formattedDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
        
        waktuDibuatInput.value = formattedDateTime;
    });
</script>

</body>
</html>