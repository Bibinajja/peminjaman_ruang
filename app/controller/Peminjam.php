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
        $data['judul'] = 'Cek Ketersediaan Ruang';
        $data['ruangan'] = $this->model('Ruang_model')->getAll();
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
        $data = [
            'user_id'         => $_SESSION['user']['user_id'],
            'ruang_id'        => $_POST['ruang_id'],
            'tanggal_mulai'   => $_POST['tanggal_mulai'] . ' ' . $_POST['jam_mulai'],
            'tanggal_selesai' => $_POST['tanggal_selesai'] . ' ' . $_POST['jam_selesai'],
            'keperluan'       => $_POST['keperluan'],
            'status'          => 'pending'
        ];

        $this->model('Peminjaman_model')->add($data);

        header("Location: " . BASEURL . "/peminjam/riwayat");
        exit;
    }


    public function riwayat()
    {
        $data = $this->model("Peminjaman_model")->getByUser($_SESSION['user']['id']);
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
