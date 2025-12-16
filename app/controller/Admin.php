<?php

class Admin extends Controller
{
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
        $data['ruang'] = $this->model('Ruang_model')->getAll();
        $this->view('admin/manajemen_ruang', $data);
    }

    public function tambah_ruang()
    {
        $this->model('Ruang_model')->add($_POST);
        header("Location: " . BASEURL . "/admin/ruang");
        exit;
    }

    public function edit_ruang()
    {
        $this->model('Ruang_model')->edit($_POST);
        header("Location: " . BASEURL . "/admin/ruang");
        exit;
    }

    public function hapus_ruang($id)
    {
        $this->model('Ruang_model')->delete($id);
        header("Location: " . BASEURL . "/admin/ruang");
        exit;
    }

    // =========================
    // MANAJEMEN USER
    // URL: /admin/user
    // =========================
    public function user()
    {
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

    public function getPending()
{
    $this->db->query("
        SELECT 
            p.peminjaman_id,
            u.nama AS nama_peminjam,
            r.nama_ruang,
            p.tanggal_mulai,
            p.tanggal_selesai,
            p.keperluan,
            p.status
        FROM peminjaman p
        JOIN users u ON p.user_id = u.user_id
        JOIN ruang r ON p.ruang_id = r.ruang_id
        WHERE p.status = 'pending'
        ORDER BY p.peminjaman_id DESC
    ");
    return $this->db->resultSet();
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
