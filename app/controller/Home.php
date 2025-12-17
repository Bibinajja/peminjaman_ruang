<?php

class Home extends Controller
{
    public function index()
    {
        $data['judul'] = 'Sistem Peminjaman Ruang';
        $this->view('home/index', $data);
        $this->view('templates/footer');
    }


    public function register()
    {
        $data['judul'] = 'Login Page';

        $this->view('home/Register', $data);
        $this->view('templates/footer');
    }

    public function login()
    {

        $data['judul'] = 'Login Page';

        $this->view('home/login', $data);
        $this->view('templates/footer');
    }


    public function auth()
    {
        // Pastikan input ada sebelum mengaksesnya untuk menghindari error 'Undefined index'
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        $user = $this->model('User_model')->login($email, $password);

        if ($user) {
            // ✅ SET SESSION LOGIN
            $_SESSION['user'] = [
                'user_id' => $user['user_id'],
                'nama'    => $user['nama'],
                'email' => $user['email'],
                'role'    => $user['role']
            ];

            // ✅ REDIRECT SESUAI ROLE
            if ($user['role'] === 'admin') {
                header("Location: " . BASEURL . "/admin");
            } elseif ($user['role'] === 'peminjam') {
                header("Location: " . BASEURL . "/peminjam");
            } elseif ($user['role'] === 'warek') {
                header("Location: " . BASEURL . "/warek");
            }
            exit;
        }

        // ❌ LOGIN GAGAL
        header("Location: " . BASEURL . "/home/login?error=1");
        exit;
    }

    public function logout()
    {
        session_destroy();
        header('Location: ' . BASEURL . '/home');
        exit;
    }
}
