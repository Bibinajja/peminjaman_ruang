<?php

class Admin extends Controller
{
    // public function __construct()
    // {

    // }

    // =========================
    // DASHBOARD
    // =========================
    public function index()
    {
        $this->view('admin/dashboard');
    }

    // =========================
    // MANAJEMEN RUANG
    // URL: /admin/ruang
    // =========================
   public function ruang()
    {
        $ruangModel = $this->model('Ruang_model');

        // Tangani semua aksi POST (tambah, edit, hapus)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action'])) {
                $data = [
                    'id'         => $_POST['id'] ?? null,
                    'nama_ruang' => trim($_POST['nama_ruang'] ?? ''),
                    'kapasitas'  => $_POST['kapasitas'] ?? 0,
                    'lokasi'     => trim($_POST['lokasi'] ?? ''),
                    'fasilitas'  => trim($_POST['fasilitas'] ?? '')  // akan disimpan ke kolom deskripsi
                ];

                if ($_POST['action'] === 'save') {
                    if (!empty($data['id'])) {
                        // Edit
                        $ruangModel->edit($data);
                    } else {
                        // Tambah
                        $ruangModel->add($data);
                    }
                } elseif ($_POST['action'] === 'delete' && !empty($data['id'])) {
                    // Hapus
                    $ruangModel->delete($data['id']);
                }
            }

            header("Location: " . BASEURL . "/admin/ruang");
            exit;
        }

        // Tampilkan daftar ruang
        $data['ruang'] = $ruangModel->getAll();
        $this->view('admin/manajemen_ruang', $data);
    }

    // =========================
    // MANAJEMEN USER
    // URL: /admin/user
    // =========================
    public function user()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $action = $_POST['action'];

            if ($action === 'save') {

                if (!empty($_POST['id'])) {
                    // UPDATE
                    $this->model('User_model')->update($_POST);
                } else {
                    // INSERT
                    $this->model('User_model')->insert($_POST);
                }
            } elseif ($action === 'delete') {
                $this->model('User_model')->delete($_POST['id']);
            }

            header('Location: ' . BASEURL . '/admin/user');
            exit;
        }
        $data['judul'] = 'Manajemen User';
        $data['users'] = $this->model('User_model')->getAll();
        $this->view('admin/manajemen_user', $data);
    }

    public function hapus_user($id)
    {
        $this->model('User_model')->delete($id);
        header("Location: " . BASEURL . "/admin/user");
        exit;
    }

    // -------------------------
    // Konfirmasi Peminjaman Tahap 1
    // -------------------------
   public function konfirmasi_peminjaman()
{
    $data['pending'] = $this->model('Peminjaman_model')->getPending(); // nama variabel jelas
    $data['title'] = 'Konfirmasi Peminjaman';
    $this->view('admin/konfirmasi_peminjaman', $data);
}


    public function detail_peminjaman($id)
    {
        $data = $this->model("Peminjaman_model")->getById($id);
        
        $this->view('admin/detail_peminjaman', $data);
    }

   

    public function setujui_peminjaman($id)
    {
        $this->model('Peminjaman_model')->approveAdmin($id);
        header("Location: " . BASEURL . "/admin/konfirmasi_peminjaman");
        exit;
    }

    public function tolak_peminjaman()
    {
        $this->model('Peminjaman_model')->rejectAdmin($_POST['id'], $_POST['alasan']);
        header("Location: " . BASEURL . "/admin/konfirmasi_peminjaman");
        exit;
    }

    // =========================
    // KONFIRMASI PENGEMBALIAN
    // =========================
    public function konfirmasi_pengembalian()
    {
        $data['pengembalian'] = $this->model('Peminjaman_model')->getPengembalian();
        $this->view('admin/konfirmasi_pengembalian', $data);
    }

    public function setujui_pengembalian($id)
    {
        $this->model('Peminjaman_model')->approvePengembalian($id);
        header("Location: " . BASEURL . "/admin/konfirmasi_pengembalian");
        exit;
    }
}