<?php

class Peminjam extends Controller
{

    public function __construct()
    {
        // 🔐 CEK LOGIN
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/home/login');
            exit;
        }

        // 🔒 CEK ROLE
        if ($_SESSION['user']['role'] !== 'peminjam') {
            header('Location: ' . BASEURL . '/home');
            exit;
        }
    }

    public function index()
    {
        $data['judul'] = 'Dashboard';
        $this->view('home/index', $data);
    }


public function cek_ketersediaan()
{
    $today = date('Y-m-d'); // Mengambil tanggal hari ini dari server
    
    // AMATI & TIRU: Ambil tanggal dari URL, jika tidak ada atau lebih kecil dari hari ini, reset ke $today
    $tanggal = $_GET['tanggal'] ?? $today;
    if ($tanggal < $today) {
        $tanggal = $today;
    }

    $lokasi  = $_GET['lokasi'] ?? '';
    $jenis   = $_GET['jenis'] ?? '';
    $search  = $_GET['search'] ?? '';

    $data['ruangan'] = $this->model('Ruang_model')->getFilteredRuangan($lokasi, $jenis, $search, $tanggal);

    // Kirim variabel ke view
    $data['tanggal'] = $tanggal;
    $data['today']   = $today; // Kirim hari ini untuk atribut 'min' di HTML
    $data['lokasi']  = $lokasi;
    $data['jenis']   = $jenis;
    $data['search']  = $search;
    $data['judul']   = 'Cek Ketersediaan Ruang';

    $this->view('peminjam/cek_ketersediaan', $data);
}
    public function form_peminjaman()
    {
        $ruang_id = $_GET['ruang_id'] ?? '';
        $tanggal  = $_GET['tanggal'] ?? date('Y-m-d');

        $data['judul'] = 'Form Peminjaman';
        $data['ruang_id'] = $ruang_id;
        $data['tanggal'] = $tanggal;

        // OPTIONAL: ambil detail ruang
        if ($ruang_id) {
            $data['ruangDipilih'] = $this->model('Ruang_model')->getById($ruang_id);
        } else {
            $data['ruangDipilih'] = null;
        }

        $data['ruangan'] = $this->model('Ruang_model')->getAll();

        $this->view('peminjam/form_peminjaman', $data);
    }


    public function peminjaman_process()
{
    // Cek login & role sudah di __construct()

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . BASEURL . '/peminjam');
        exit();
    }

    // Ambil data dari form
  // Di dalam Peminjam.php -> peminjaman_process
$data = [
    'user_id'         => $_SESSION['user']['user_id'],
    'ruang_id'        => $_POST['ruang_id'],
    'nama_peminjam'   => trim($_POST['nama_peminjam']),
    'tanggal_mulai'   => $_POST['tanggal_mulai'] . ' ' . $_POST['jam_mulai'] . ':00',
    'tanggal_selesai' => $_POST['tanggal_selesai'] . ' ' . $_POST['jam_selesai'] . ':00',
    'keperluan'       => trim($_POST['keperluan']),
    'status'          => 'pending'
];

    // Validasi sederhana
    if (empty($data['ruang_id']) || empty($data['tanggal_mulai']) || empty($data['tanggal_selesai']) || empty($data['keperluan'])) {
        // Kalau ada yang kosong, redirect kembali dengan pesan error (bisa pakai flash message)
        header('Location: ' . BASEURL . '/peminjam/form_peminjaman?error=1');
        exit();
    }

    // Cek konflik jadwal (opsional tapi penting)
    $konflik = $this->model('Peminjaman_model')->cekKonflik(
        $data['ruang_id'],
        $data['tanggal_mulai'],
        $data['tanggal_selesai']
    );

    if ($konflik) {
        header('Location: ' . BASEURL . '/peminjam/form_peminjaman?ruang_id=' . $data['ruang_id'] . '&error=konflik');
        exit();
    }

    // Insert ke database
    $result = $this->model('Peminjaman_model')->add($data);

    if ($result) {
        // Sukses → redirect ke riwayat
        header('Location: ' . BASEURL . '/peminjam/riwayat');
        exit();
    } else {
        // Gagal
        header('Location: ' . BASEURL . '/peminjam/form_peminjaman?error=gagal');
        exit();
    }
}


    public function riwayat()
    {
     $data['riwayat'] = $this->model("Peminjaman_model")->getByUser($_SESSION['user']['user_id']);
    
    $data['judul'] = 'Riwayat Peminjaman';
    
    $this->view('peminjam/riwayat_peminjaman', $data);
    }

    public function form_pembatalan($id)
    {
        $data = $this->model("Peminjaman_model")->getById($id);
        $this->view('peminjam/form_pembatalan', $data);
    }

    public function pembatalan_process()
    {
        $id = $_POST['id'];
        $alasan = $_POST['alasan'];

        $this->model("Peminjaman_model")->cancelByUser($id, $alasan);

        header("Location:" . BASEURL . "/peminjam/riwayat");
    }

    public function form_pengembalian($id = null)
    {
        //coba
        // Jika ID kosong, tetap tampilkan halaman kosong
        if ($id === null) {
            // load view tanpa data
            $this->view('peminjam/form_pengembalian', [
                'title' => 'Form Pengembalian',
                'data'  => null
            ]);
            return;
        }

        // if ($id === null) {
        //     echo "ID tidak ditemukan!";
        //     return;
        // }
        $data = $this->model("Peminjaman_model")->getById($id);
        $this->view('peminjam/form_pengembalian', $data);
    }

    public function pengembalian_process()
    {
        $id = $_POST['id'];

        // upload bukti
        $file = $_FILES['bukti']['name'];
        move_uploaded_file($_FILES['bukti']['tmp_name'], "uploads/" . $file);

        $this->model("Peminjaman_model")->pengembalian($id, $file);

        header("Location:" . BASEURL . "/peminjam/riwayat");
    }
}
