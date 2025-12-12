<?php

class Peminjam extends Controller
{
    public function index()
    {
        $this->view('peminjam/dashboard');
    }

    public function cek_ketersediaan()
    {
        $ruangan = $this->model('Ruang_model')->getAll();
        $this->view('peminjam/cek_ketersediaan', $ruangan);
    }

    public function form_peminjaman()
    {
        $ruangan = $this->model('Ruang_model')->getAll();
        $this->view('peminjam/form_peminjaman', $ruangan);
    }

    public function peminjaman_process()
    {
        $data = [
            'user_id'   => $_SESSION['user']['id'],
            'ruang_id'  => $_POST['ruang_id'],
            'tgl_mulai' => $_POST['tgl_mulai'],
            'tgl_selesai' => $_POST['tgl_selesai'],
            'kegiatan'  => $_POST['kegiatan'],
            'status'    => 'pending'
        ];

        $this->model("Peminjaman_model")->add($data);
        header("Location:" . BASEURL . "/peminjam/riwayat");
    }

    public function riwayat()
    {
        $data = $this->model("Peminjaman_model")->getByUser($_SESSION['user']['id']);
        $this->view('peminjam/riwayat_peminjaman', $data);
    }

    public function form_pembatalan($id)
    {
        $data = $this->model("Peminjaman_model")->getById($id);
        $this->view('peminjam/form_pembatalan', $data);
    }

    public function pembatalan_process()
    {
        $id = $_POST['id'];
        $alasan = $_POST['alasan'];

        $this->model("Peminjaman_model")->cancelByUser($id, $alasan);

        header("Location:" . BASEURL . "/peminjam/riwayat");
    }

    public function form_pengembalian($id = null)
    {
        //coba
        // Jika ID kosong, tetap tampilkan halaman kosong
        if ($id === null) {
            // load view tanpa data
            $this->view('peminjam/form_pengembalian', [
                'title' => 'Form Pengembalian',
                'data'  => null
            ]);
            return;
        }

        // if ($id === null) {
        //     echo "ID tidak ditemukan!";
        //     return;
        // }
        $data = $this->model("Peminjaman_model")->getById($id);
        $this->view('peminjam/form_pengembalian', $data);
    }

    public function pengembalian_process()
    {
        $id = $_POST['id'];

        // upload bukti
        $file = $_FILES['bukti']['name'];
        move_uploaded_file($_FILES['bukti']['tmp_name'], "uploads/" . $file);

        $this->model("Peminjaman_model")->pengembalian($id, $file);

        header("Location:" . BASEURL . "/peminjam/riwayat");
    }
}
