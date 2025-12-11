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

    public function tambah()
    {
        if ($_SESSION['user']['role'] !== 'admin') {
            header("Location: " . BASEURL . "/home");
            exit;
        }

        $data = [
            'nama'      => $_POST['nama'],
            'username'  => $_POST['username'],
            'password'  => $_POST['password'],
            'role'      => $_POST['role']    // admin bisa set role: admin/peminjam/warek
        ];

        $this->model("User_model")->add($data);
        header("Location:" . BASEURL . "/user");
    }

    public function edit()
    {
        if ($_SESSION['user']['role'] !== 'admin') {
            header("Location: " . BASEURL . "/home");
            exit;
        }

        $data = [
            'id'        => $_POST['id'],
            'nama'      => $_POST['nama'],
            'username'  => $_POST['username'],
            'role'      => $_POST['role'],
        ];

        if (!empty($_POST['password'])) {
            $data['password'] = $_POST['password']; // update password jika diisi
        }

        $this->model("User_model")->edit($data);
        header("Location:" . BASEURL . "/user");
    }

    public function hapus($id)
    {
        if ($_SESSION['user']['role'] !== 'admin') {
            header("Location: " . BASEURL . "/home");
            exit;
        }

        $this->model("User_model")->delete($id);
        header("Location:" . BASEURL . "/user");
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
            'username' => $_POST['username']
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
