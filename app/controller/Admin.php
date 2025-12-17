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
    $data['title'] = 'Konfirmasi Pengembalian';
    $data['pengembalian'] = $this->model('Pengembalian_model')->getPengembalian();

    // $this->view('templates/header', $data);          // jika pakai header
    $this->view('admin/konfirmasi_pengembalian', $data);
    $this->view('templates/footer');                 // jika pakai footer
}

    public function approvePengembalian($id)
{
    // Update status pengembalian jadi disetujui
    $this->db->query("UPDATE {$this->table} SET status = 'disetujui' WHERE {$this->pk} = :id");
    $this->db->bind(':id', $id);
    $this->db->execute();

    // Update status peminjaman jadi 'selesai'
    $this->db->query("
        UPDATE peminjaman p 
        JOIN {$this->table} peng ON p.peminjaman_id = peng.peminjaman_id 
        SET p.status = 'selesai' 
        WHERE peng.{$this->pk} = :id
    ");
    $this->db->bind(':id', $id);
    return $this->db->execute();
}

public function rejectPengembalian($id, $reason)
{
    // Update status dan alasan admin di tabel pengembalian
    $this->db->query("
        UPDATE {$this->table} 
        SET status = 'ditolak', alasan_admin = :reason 
        WHERE {$this->pk} = :id
    ");
    $this->db->bind(':id', $id);
    $this->db->bind(':reason', $reason);
    $this->db->execute();

    // Optional: kembalikan status peminjaman ke 'disetujui'
    $this->db->query("
        UPDATE peminjaman p 
        JOIN {$this->table} peng ON p.peminjaman_id = peng.peminjaman_id 
        SET p.status = 'disetujui' 
        WHERE peng.{$this->pk} = :id
    ");
    $this->db->bind(':id', $id);
    return $this->db->execute();

    if ($action === 'approve') {
    $this->model('Pengembalian_model')->approvePengembalian($pengembalian_id);
    Flasher::setFlash('Pengembalian disetujui', 'success');
} elseif ($action === 'reject') {
    $this->model('Pengembalian_model')->rejectPengembalian($pengembalian_id, $reason);
    Flasher::setFlash('Pengembalian ditolak', 'warning');
}
    // header("Location: " . BASEURL . "/admin/konfirmasi_pengembalian");
    // exit;
}

}
