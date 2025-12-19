<?php

class Profil extends Controller
{
    // Halaman utama profil (GET /profil)
    public function index()
    {
        // Cek login
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/home/login');
            exit;
        }

        // Ambil data user dari session
        $user_id = $_SESSION['user']['user_id'];

        // Ambil data lengkap user dari model
        $data['user'] = $this->model('User_model')->getUserById($user_id);

        // Jika user tidak ditemukan (session invalid)
        if (!$data['user']) {
            session_destroy();
            header('Location: ' . BASEURL . '/home/login');
            exit;
        }

        $data['title'] = 'Profil Pengguna';

        // === INI TEMPATNYA ===
        $this->view('home/profil', $data);
        // =====================
    }

    // Proses update setelah submit form (POST /profil/update)
    public function update()
    {
        // Cek login
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/home/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASEURL . '/profil');
            exit;
        }

        $user_id = $_SESSION['user']['user_id'];
        $nama    = trim($_POST['nama']);
        $email   = trim($_POST['email']);
        $password = $_POST['password'] ?? '';

        $result = $this->model('User_model')->updateProfil($user_id, $nama, $email, $password);

        // Refresh data user
        $data['user'] = $this->model('User_model')->getUserById($user_id);
        $data['title'] = 'Profil Pengguna';

        if ($result['success']) {
            $_SESSION['user']['nama']  = $nama;
            $_SESSION['user']['email'] = $email;
            $data['success_message'] = "Profil berhasil diperbarui!";
        } else {
            $data['error_message'] = $result['message'] ?? "Gagal memperbarui profil.";
        }

        // === INI JUGA TEMPATNYA (setelah update, tampilkan lagi profil) ===
        $this->view('home/profil', $data);
        // =================================================================
    }
}