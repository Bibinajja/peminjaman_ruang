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
        $this->view('templates/header');
        $this->view('home/register');
        $this->view('templates/footer');
    }

    public function register_process()
    {
        $data = [
            // 'username'  => $_POST['username'],
            'nama'      => $_POST['email'],
            'password'  => $_POST['password'],
            'role'      => 'peminjam'  // otomatis peminjam
        ];

        $this->model('User_model')->register($data);

        header("Location:" . BASEURL . "/home/login");
    }

    public function logout()
    {
        session_destroy();
        header("Location: " . BASEURL . "/");
    }
}
