<?php

class Warek extends Controller
{
    public function index()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'warek') {
            header('Location: ' . BASEURL . '/home/login');
            exit;
        }

        $data['judul'] = 'Dashboard Warek';
        $data['namaWarek'] = $_SESSION['user']['nama'] ?? 'Warek';
        $data['pendingCount']  = 0;
        $data['approvedCount'] = 0;
        $data['totalCount']    = 0;
        $data['historyData']   = [];
        $this->view('warek/dashboard', $data);
    }

    public function konfirmasi()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'warek') {
            header('Location: ' . BASEURL . '/home/login');
            exit;
        }

        $data['judul'] = 'Konfirmasi Peminjaman';
        $data['namaWarek'] = $_SESSION['user']['nama'] ?? 'Warek';
        $data['peminjaman'] = $this->model('Peminjaman_model')->getTahapWarek();

        $this->view('warek/konfirmasi_warek', $data);
    }


    public function setujui($id)
    {
        $this->model('Peminjaman_model')->approveWarek($id);

        header('Location: ' . BASEURL . '/warek/konfirmasi');
        exit;
    }

    public function tolak()
    {
        $id     = $_POST['id'] ?? null;
        $alasan = $_POST['alasan'] ?? '';

        if ($id) {
            $this->model('Peminjaman_model')->rejectWarek($id, $alasan);
        }

        header('Location: ' . BASEURL . '/warek/konfirmasi');
        exit;
    }
}
