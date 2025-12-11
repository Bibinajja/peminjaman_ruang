<?php

class Warek extends Controller
{
    public function index()
    {
        $this->view('warek/dashboard');
    }

    public function konfirmasi()
    {
        $data = $this->model("Peminjaman_model")->getTahap1();
        $this->view('warek/konfirmasi_warek', $data);
    }

    public function setujui($id)
    {
        $this->model("Peminjaman_model")->approveWarek($id);
        header("Location:" . BASEURL . "/warek/konfirmasi");
    }

    public function tolak()
    {
        $id = $_POST['id'];
        $alasan = $_POST['alasan'];

        $this->model("Peminjaman_model")->rejectWarek($id, $alasan);
        header("Location:" . BASEURL . "/warek/konfirmasi");
    }
}
