<?php

class Home extends Controller
{
    public function index()
    {
        // $this->view('templates/header');
        $this->view('home/index');
        $this->view('templates/footer');
    }

    public function login()
    {

        $this->view('home/login');
        $this->view('../view/templates/footer');
    }

    public function login_process()
    {
        // echo "cek eror login";

        $username = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->model('User_model')->login($username, $password);

        if (!$user) {
            $_SESSION['error'] = "Username atau password salah!";
            header("Location: " . BASEURL . "/home/login");
            exit;
        }

        $_SESSION['user'] = $user;

        if ($user['role'] == 'admin') {
            header("Location: " . BASEURL . "/admin");
        } elseif ($user['role'] == 'warek') {
            header("Location: " . BASEURL . "/warek");
        } else {
            header("Location: " . BASEURL . "/peminjam");
        }
    }

    public function register()
    {
        $this->view('home/register');
        $this->view('templates/footer');
    }

    public function register_process()
    {
        // Ambil data dari form
        $nama     = trim($_POST['nama']);
        $email    = trim($_POST['email']);
        $password = $_POST['password'];
        $confirm  = $_POST['password_confirm'];

        // 1. Validasi kosong
        if ($nama == '' || $email == '' || $password == '' || $confirm == '') {
            $_SESSION['error'] = "Semua field wajib diisi!";
            header("Location: " . BASEURL . "/home/register");
            exit;
        }

        // 2. Validasi password
        if ($password !== $confirm) {
            $_SESSION['error'] = "Password tidak sama!";
            header("Location: " . BASEURL . "/home/register");
            exit;
        }

        // 3. Cek email unik
        $userModel = $this->model('User_model');
        if ($userModel->getUserByEmail($email)) {
            $_SESSION['error'] = "Email sudah terdaftar!";
            header("Location: " . BASEURL . "/home/register");
            exit;
        }

        // 4. Hash password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // 5. Insert user (role default PEMINJAM)
        $insert = $userModel->register([
            'nama'     => $nama,
            'email'    => $email,
            'password' => $passwordHash
        ]);

        if ($insert) {
            $_SESSION['success'] = "Registrasi berhasil, silakan login.";
            header("Location: " . BASEURL . "/home/login");
        } else {
            $_SESSION['error'] = "Registrasi gagal!";
            header("Location: " . BASEURL . "/home/register");
        }
    }


    public function logout()
    {
        session_destroy();
        header("Location: " . BASEURL . "/");
    }
}
