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

        $this->view('home/login', $data);
        $this->view('templates/footer');
    }
    public function profil()
    {
        // Cek login
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/home/login');
            exit;
        }

        $user_id = $_SESSION['user']['user_id'];

        // Ambil data user
        $data['user'] = $this->model('User_model')->getUserById($user_id);

        // Proses update profil
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
            $nama     = trim($_POST['nama']);
            $email    = trim($_POST['email']);
            $password = $_POST['password'] ?? '';

            $result = $this->model('User_model')->updateProfil($user_id, $nama, $email, $password);

            if ($result['success']) {
                // Update session
                $_SESSION['user']['nama']  = $nama;
                $_SESSION['user']['email'] = $email;

                Flasher::setFlash('Profil berhasil diperbarui!', 'success');
            } else {
                Flasher::setFlash($result['message'], 'danger');
            }

            // Refresh data user setelah update
            $data['user'] = $this->model('User_model')->getUserById($user_id);
        }

        $data['title'] = 'Profil Pengguna';
        $this->view('templates/header', $data);
        $this->view('home/profil', $data);  // view murni HTML
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
