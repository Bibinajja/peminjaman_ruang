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

    // FUNGSI BARU UNTUK MENANGANI FORM (TAMBAH & EDIT)
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
                'email'     => $_POST['email'], // PERBAIKAN: username diganti email
                'role'      => $_POST['role'],
            ];

            // Hanya update password jika diisi
            if (!empty($_POST['password'])) {
                $data['password'] = $_POST['password'];
            }

            if ($this->model("User_model")->edit($data) > 0) {
                // Redirect dengan pesan sukses (status=edited)
                header("Location:" . BASEURL . "/user?status=edited");
                exit;
            }
        } else {
            // --- LOGIC TAMBAH ---
            $data = [
                'nama'      => $_POST['nama'],
                'email'     => $_POST['email'], // PERBAIKAN: username diganti email
                'password'  => $_POST['password'],
                'role'      => $_POST['role']
            ];

            if ($this->model("User_model")->add($data) > 0) {
                // Redirect dengan pesan sukses (status=added)
                header("Location:" . BASEURL . "/user?status=added");
                exit;
            }
        }

        // Jika gagal atau tidak ada perubahan
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

    // Optional: Profil User (untuk peminjam)
    public function profil()
    {
        $id = $_SESSION['user']['id'];
        $data['user'] = $this->model("User_model")->getById($id);
        $this->view('peminjam/profil', $data);
    }

    public function update_profil()
    {
        $id = $_SESSION['user']['id'];

        $data = [
            'id'       => $id,
            'nama'     => $_POST['nama'],
            'email'    => $_POST['email'] // Sesuaikan juga disini jika perlu
        ];

        if (!empty($_POST['password'])) {
            $data['password'] = $_POST['password'];
        }

        $this->model("User_model")->edit($data);

        // refresh session
        $_SESSION['user'] = $this->model("User_model")->getById($id);

        header("Location:" . BASEURL . "/user/profil");
    }
}
