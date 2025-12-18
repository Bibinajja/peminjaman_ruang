<?php

class Ruang_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAll()
    {
        $this->db->query("SELECT * FROM ruang ORDER BY ruang_id ASC");
        return $this->db->resultSet();
    }

    public function getFilteredRuangan($lokasi, $jenis, $search, $tanggal)
    {
        $query = "SELECT * FROM ruang WHERE 1=1";

        if ($lokasi !== '') {
            $query .= " AND lokasi = :lokasi";
        }

        if ($jenis !== '') {
            $query .= " AND deskripsi = :jenis";
        }

        if ($search !== '') {
            $query .= " AND nama_ruang LIKE :search";
        }

        $this->db->query($query);

        if ($lokasi !== '') {
            $this->db->bind(':lokasi', $lokasi);
        }

        if ($jenis !== '') {
            $this->db->bind(':jenis', $jenis);
        }

        if ($search !== '') {
            $this->db->bind(':search', "%$search%");
        }

        $ruangan = $this->db->resultSet();

        foreach ($ruangan as &$r) {
            $r['is_booked'] = $this->cekKetersediaan($r['ruang_id'], $tanggal);
        }

        return $ruangan;
    }

   private function cekKetersediaan($ruang_id, $tanggal)
{
    // MODIFIKASI: Mencari peminjaman yang tumpang tindih dengan TANGGAL tersebut
    // Kita cek apakah ada peminjaman yang 'aktif' pada hari itu (00:00:00 s/d 23:59:59)
    $tgl_mulai = $tanggal . ' 00:00:00';
    $tgl_selesai = $tanggal . ' 23:59:59';

    $this->db->query("
        SELECT COUNT(*) as total FROM peminjaman
        WHERE ruang_id = :id
        AND (
            (tanggal_mulai BETWEEN :tgl_awal AND :tgl_akhir) OR
            (tanggal_selesai BETWEEN :tgl_awal AND :tgl_akhir) OR
            (tanggal_mulai <= :tgl_awal AND tanggal_selesai >= :tgl_akhir)
        )
        AND status IN ('pending','disetujui','konfirmasi_admin','konfirmasi_warek')
    ");
    $this->db->bind(':id', $ruang_id);
    $this->db->bind(':tgl_awal', $tgl_mulai);
    $this->db->bind(':tgl_akhir', $tgl_selesai);

    return $this->db->single()['total'] > 0;
}


   public function add($data)
    {
        $query = "INSERT INTO ruang (nama_ruang, kapasitas, lokasi, deskripsi, status)
                  VALUES (:nama_ruang, :kapasitas, :lokasi, :deskripsi, 'aktif')";

        $this->db->query($query);
        $this->db->bind(':nama_ruang', $data['nama_ruang']);
        $this->db->bind(':kapasitas', $data['kapasitas']);
        $this->db->bind(':lokasi', $data['lokasi']);
        $this->db->bind(':deskripsi', $data['fasilitas']); // fasilitas dari form → simpan ke deskripsi

        return $this->db->execute();
    }

    public function edit($data)
    {
        $query = "UPDATE ruang SET 
                  nama_ruang = :nama_ruang,
                  kapasitas = :kapasitas,
                  lokasi = :lokasi,
                  deskripsi = :deskripsi
                  WHERE ruang_id = :id";

        $this->db->query($query);
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':nama_ruang', $data['nama_ruang']);
        $this->db->bind(':kapasitas', $data['kapasitas']);
        $this->db->bind(':lokasi', $data['lokasi']);
        $this->db->bind(':deskripsi', $data['fasilitas']);

        return $this->db->execute();
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM ruang WHERE ruang_id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}