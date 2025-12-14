<?php

class Home extends Controller
{
    public function index()
    {
        $data['judul'] = 'Sistem Peminjaman Ruang';
        $this->view('home/index', $data);
        $this->view('templates/footer');
    }

    public function login()
    {
        $data['judul'] = 'Login Page';

        $this->view('home/login', $data);
        $this->view('templates/footer');
    }
    public function register()
    {
        $data['judul'] = 'Login Page';

        $this->view('home/login', $data);
        $this->view('templates/footer');
    }

    public function auth()
    {
        // Proses Login u ser
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $user = $this->model('User_model')->getUserByEmail($_POST['email']);

            // Cek user ada & password cocok (Disarankan pakai password_verify jika di hash)
            // Disini saya pakai contoh perbandingan langsung untuk simplifikasi
            if ($user && $_POST['password'] == $user['password']) {

                // Set Session
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['nama'] = $user['nama'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['loggedin'] = true;

                // Redirect sesuai Role
                if ($user['role'] == 'admin') {
                    header('Location: ' . BASEURL . '/admin');
                } elseif ($user['role'] == 'warek') {
                    header('Location: ' . BASEURL . '/warek');
                } else {
                    header('Location: ' . BASEURL . '/peminjam');
                }
                exit;
            } else {
                // Login Gagal memsukkan user 
                header('Location: ' . BASEURL . '/home/login');
                exit;
            }
        }
    }


    public function logout()
    {
        session_destroy();
        header('Location: ' . BASEURL . '/home');
        exit;
    }
}
