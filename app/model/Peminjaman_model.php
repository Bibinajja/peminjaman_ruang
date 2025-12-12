<?php

class Peminjaman_model
{

    private $table = 'peminjaman';
    private $db;

    public function __construct()
    {
        $this->db = new Database; // Pastikan kamu punya class Database
    }

    /**
     * Ambil daftar permintaan pengembalian (status = 'pengembalian')
     */
    public function getPengembalian()
    {
        $query = "
            SELECT 
                p.peminjaman_id,
                u.nama AS peminjam,
                r.nama_ruang AS ruang,
                p.tanggal_mulai,
                p.tanggal_selesai,
                p.alasan_pembatalan AS alasan
            FROM {$this->table} p
            JOIN users u ON p.user_id = u.user_id
            JOIN ruang r ON p.ruang_id = r.ruang_id
            WHERE p.status = 'pengembalian'
            ORDER BY p.peminjaman_id DESC
        ";

        $this->db->query($query);
        return $this->db->resultSet();
    }

    /**
     * Setujui pengembalian
     */
    public function approvePengembalian($id)
    {
        $query = "UPDATE {$this->table} SET status = 'selesai' WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        return $this->db->execute();
    }

    /**
     * Tolak pengembalian
     */
    public function rejectPengembalian($id, $reason)
    {
        $query = "
            UPDATE {$this->table} 
            SET status = 'ditolak', alasan_admin = :reason 
            WHERE id = :id
        ";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->bind('reason', $reason);
        return $this->db->execute();
    }
}
