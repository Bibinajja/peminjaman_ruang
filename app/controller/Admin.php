<?php

class Admin extends Controller
{
    public function index()
    {
        $this->view('admin/dashboard');
    }

    // -------------------------
    // CRUD untuk Ruang
    // -------------------------
    public function ruang()
    {
        $data = $this->model("Ruang_model")->getAll();
        $this->view('admin/manajemen_ruang', $data);
    }

    public function tambah_ruang()
    {
        $this->model("Ruang_model")->add($_POST);
        header("Location:" . BASEURL . "/admin/ruang");
    }

    public function edit_ruang()
    {
        $this->model("Ruang_model")->edit($_POST);
        header("Location:" . BASEURL . "/admin/ruang");
    }

    public function hapus_ruang($id)
    {
        $this->model("Ruang_model")->delete($id);
        header("Location:" . BASEURL . "/admin/ruang");
    }

    // -------------------------
    // CRUD User
    // -------------------------
    public function user()
    {
        $data = $this->model("User_model")->getAll();
        $this->view('admin/manajemen_user', $data);
    }

    public function tambah_user() //untuk apa?
    {
        $this->model("User_model")->add($_POST);
        header("Location:" . BASEURL . "/admin/user");
    }

    public function edit_user()
    {
        $this->model("User_model")->edit($_POST);
        header("Location:" . BASEURL . "/admin/user");
    }

    public function hapus_user($id)
    {
        $this->model("User_model")->delete($id);
        header("Location:" . BASEURL . "/admin/user");
    }

    // -------------------------
    // Konfirmasi Peminjaman Tahap 1
    // -------------------------
    public function konfirmasi_peminjaman()
    {
        $data = $this->model("Peminjaman_model")->getPending();
        $this->view('admin/konfirmasi_peminjaman', $data);
    }

    public function detail_peminjaman($id)
    {
        $data = $this->model("Peminjaman_model")->getById($id);
        $this->view('admin/detail_peminjaman', $data);
    }

    public function setujui_peminjaman($id)
    {
        $this->model("Peminjaman_model")->approveAdmin($id);
        header("Location:" . BASEURL . "/admin/konfirmasi_peminjaman");
    }

    public function tolak_peminjaman()
    {
        $id = $_POST['id'];
        $alasan = $_POST['alasan'];

        $this->model("Peminjaman_model")->rejectAdmin($id, $alasan);
        header("Location:" . BASEURL . "/admin/konfirmasi_peminjaman");
    }

    // -------------------------
    // Konfirmasi Pembatalan
    // -------------------------
    public function konfirmasi_pembatalan()
    {
        $data = $this->model("Peminjaman_model")->getPembatalanPending();
        $this->view('admin/konfirmasi_pembatalan', $data);
    }

    public function proses_pembatalan()
    {
        $id = $_POST['id'];
        $aksi = $_POST['aksi'];
        $this->model("Peminjaman_model")->prosesPembatalan($id, $aksi);
        header("Location:" . BASEURL . "/admin/konfirmasi_pembatalan");
    }

    // -------------------------
    // Konfirmasi Pengembalian
    // -------------------------
    public function konfirmasi_pengembalian()
    {
        //blackbox
        // $data = $this->model("Peminjaman_model")->getPengembalianPending();
        //gpt
        $data = $this->model("Peminjaman_model")->getPengembalian();

        $this->view('admin/konfirmasi_pengembalian', $data);
    }

    //gpt
    //     public function konfirmasi_pengembalian()
    // {
    //     $pengembalian = $this->model("Peminjaman_model")->getPengembalianPending();
    //     $this->view('admin/konfirmasi_pengembalian', ['pengembalian' => $pengembalian]);
    // }

    public function setujui_pengembalian($id)
    {
        $this->model("Peminjaman_model")->approvePengembalian($id);
        header("Location: " . BASEURL . "/admin/konfirmasi_pengembalian");
    }




    public function proses_pengembalian()
    {
        $id = $_POST['id'];
        $aksi = $_POST['aksi'];
        $alasan = $_POST['alasan'] ?? null;

        $this->model("Peminjaman_model")->prosesPengembalian($id, $aksi, $alasan);
        header("Location:" . BASEURL . "/admin/konfirmasi_pengembalian");
    }
}
// gpt
// public function proses_pengembalian()
// {
//     $id = $_POST['id'];
//     $action = $_POST['action'];

//     $model = $this->model('Peminjaman_model');

//     if ($action == "approve") {
//         $model->approvePengembalian($id);
//     } else if ($action == "reject") {
//         $reason = $_POST['reason'];
//         $model->rejectPengembalian($id, $reason);
//     }

//     header("Location: " . BASEURL . "/admin/konfirmasi_pengembalian");
//     exit;
// }
