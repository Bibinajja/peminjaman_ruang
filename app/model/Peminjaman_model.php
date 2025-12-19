<?php

class Peminjaman_model
{
    private $db;
    private $table = 'peminjaman';

    public function __construct()
    {
        $this->db = new Database;
    }

    /**
     * Menambah data peminjaman baru
     */
    public function add($data)
    {
        try {
            $query = "INSERT INTO {$this->table} 
                     (user_id, ruang_id, nama_peminjam, tanggal_mulai, tanggal_selesai, keperluan, status) 
                     VALUES 
                     (:user_id, :ruang_id, :nama_peminjam, :tanggal_mulai, :tanggal_selesai, :keperluan, :status)";

            $this->db->query($query);
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':ruang_id', $data['ruang_id']);
            $this->db->bind(':nama_peminjam', $data['nama_peminjam']);
            $this->db->bind(':tanggal_mulai', $data['tanggal_mulai']);
            $this->db->bind(':tanggal_selesai', $data['tanggal_selesai']);
            $this->db->bind(':keperluan', $data['keperluan']);
            $this->db->bind(':status', $data['status']);

            $this->db->execute();

            return $this->db->rowCount();
        } catch (Exception $e) {
            error_log("Error add peminjaman: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Cek konflik jadwal ruangan
     */
    public function cekKonflik($ruang_id, $tanggal_mulai, $tanggal_selesai, $peminjaman_id = null)
    {
        try {
            $query = "SELECT COUNT(*) as total 
                     FROM {$this->table} 
                     WHERE ruang_id = :ruang_id 
                     AND status IN ('pending', 'disetujui', 'dipinjam')
                     AND (
                         (tanggal_mulai <= :tanggal_mulai AND tanggal_selesai >= :tanggal_mulai) OR
                         (tanggal_mulai <= :tanggal_selesai AND tanggal_selesai >= :tanggal_selesai) OR
                         (tanggal_mulai >= :tanggal_mulai AND tanggal_selesai <= :tanggal_selesai)
                     )";

            if ($peminjaman_id) {
                $query .= " AND peminjaman_id != :peminjaman_id";
            }

            $this->db->query($query);
            $this->db->bind(':ruang_id', $ruang_id);
            $this->db->bind(':tanggal_mulai', $tanggal_mulai);
            $this->db->bind(':tanggal_selesai', $tanggal_selesai);

            if ($peminjaman_id) {
                $this->db->bind(':peminjaman_id', $peminjaman_id);
            }

            $result = $this->db->single();

            return ($result['total'] > 0);
        } catch (Exception $e) {
            error_log("Error cek konflik: " . $e->getMessage());
            return true;
        }
    }

    /**
     * Ambil peminjaman berdasarkan user_id
     */
    public function getByUser($user_id)
    {
        try {
            $query = "SELECT p.*, r.nama_ruang, r.lokasi, r.jenis_ruang
                     FROM {$this->table} p
                     LEFT JOIN ruang r ON p.ruang_id = r.ruang_id
                     WHERE p.user_id = :user_id
                     ORDER BY p.tanggal_mulai DESC";

            $this->db->query($query);
            $this->db->bind(':user_id', $user_id);

            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Error getByUser: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Ambil peminjaman berdasarkan ID
     */
    public function getById($id)
    {
        try {
            $query = "SELECT p.*, r.nama_ruang, r.lokasi, r.jenis_ruang
                     FROM {$this->table} p
                     LEFT JOIN ruang r ON p.ruang_id = r.ruang_id
                     WHERE p.peminjaman_id = :id";

            $this->db->query($query);
            $this->db->bind(':id', $id);

            return $this->db->single();
        } catch (Exception $e) {
            error_log("Error getById: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Pembatalan oleh user
     */
    public function cancelByUser($id, $alasan)
    {
        try {
            $query = "UPDATE {$this->table} 
                     SET status = 'dibatalkan', 
                         alasan_pembatalan = :alasan
                     WHERE peminjaman_id = :id";

            $this->db->query($query);
            $this->db->bind(':id', $id);
            $this->db->bind(':alasan', $alasan);

            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Error cancelByUser: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Pengembalian ruangan
     */
    public function pengembalian($id, $bukti)
    {
        try {
            $query = "UPDATE {$this->table} 
                     SET status = 'dikembalikan', 
                         bukti_pengembalian = :bukti
                     WHERE peminjaman_id = :id";

            $this->db->query($query);
            $this->db->bind(':id', $id);
            $this->db->bind(':bukti', $bukti);

            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Error pengembalian: " . $e->getMessage());
            return false;
        }
    }
}
