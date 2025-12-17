<?php

class User extends Controller
{
    public function index()
    {
        // Jika bukan admin → larang akses
        if ($_SESSION['user']['role'] !== 'admin') {
            header("Location: " . BASEURL . "/home");
            exit;
        }

        $data['users'] = $this->model("User_model")->getAll();
        $this->view('admin/manajemen_user', $data);
    }

    public function simpan()
    {
        if ($_SESSION['user']['role'] !== 'admin') {
            header("Location: " . BASEURL . "/home");
            exit;
        }

        // Cek apakah ini Edit (punya ID) atau Tambah (tidak punya ID)
        if (!empty($_POST['id'])) {
            // --- LOGIC EDIT ---
            $data = [
                'id'        => $_POST['id'],
                'nama'      => $_POST['nama'],
                'email'     => $_POST['email'],
                'role'      => $_POST['role'],
            ];

            // Hanya update password jika diisi
            if (!empty($_POST['password'])) {
                $data['password'] = $_POST['password'];
            }

            if ($this->model("User_model")->edit($data) > 0) {
                header("Location:" . BASEURL . "/user?status=edited");
                exit;
            }
        } else {
            // --- LOGIC TAMBAH ---
            $data = [
                'nama'      => $_POST['nama'],
                'email'     => $_POST['email'],
                'password'  => $_POST['password'],
                'role'      => $_POST['role']
            ];

            if ($this->model("User_model")->add($data) > 0) {
                header("Location:" . BASEURL . "/user?status=added");
                exit;
            }
        }

        header("Location:" . BASEURL . "/user");
    }

    public function hapus($id)
    {
        if ($_SESSION['user']['role'] !== 'admin') {
            header("Location: " . BASEURL . "/home");
            exit;
        }

        if ($this->model("User_model")->delete($id) > 0) {
            header("Location:" . BASEURL . "/user?status=deleted");
        } else {
            header("Location:" . BASEURL . "/user");
        }
    }

    // ==========================================
    // BAGIAN INI SUDAH DIUBAH SESUAI PERMINTAAN
    // ==========================================
    public function profil()
    {
        // Ambil ID dari session
        $id = $_SESSION['user']['user_id'];

        // Ambil data user terbaru
        $data['user'] = $this->model("User_model")->getById($id);

        // PERUBAHAN DISINI: Mengarah ke folder home
        $this->view('home/profil', $data);
    }

    public function update_profil()
    {
        $id = $_SESSION['user']['user_id'];

        $data = [
            'id'       => $id,
            'nama'     => $_POST['nama'],
            'email'    => $_POST['email']
        ];

        if (!empty($_POST['password'])) {
            $data['password'] = $_POST['password'];
        }

        $this->model("User_model")->edit($data);

        // Refresh session
        $_SESSION['user'] = $this->model("User_model")->getById($id);

        header("Location:" . BASEURL . "/user/profil");
    }
}
