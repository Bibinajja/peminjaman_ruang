<?php

class Peminjaman_model
{
    private $table = 'peminjaman';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // -------------------------------
    // 1. Ambil daftar peminjaman yang MENUNGGU KONFIRMASI ADMIN (pending)
    // -------------------------------
    public function getPending()
    {
        $query = "
            SELECT 
                p.peminjaman_id,
                u.nama AS nama_peminjam,
                r.nama_ruang,
                p.tanggal_mulai,
                p.tanggal_selesai,
                p.keperluan,
                p.status
            FROM {$this->table} p
            JOIN users u ON p.user_id = u.user_id
            JOIN ruang r ON p.ruang_id = r.ruang_id
            WHERE p.status = 'pending' OR p.status = 'menunggu konfirmasi'
            ORDER BY p.peminjaman_id DESC
        ";

        $this->db->query($query);
        return $this->db->resultSet();
    }

    // -------------------------------
    // 2. Ambil detail satu peminjaman berdasarkan ID
    // -------------------------------
    public function getById($id)
    {
        $query = "
            SELECT 
                p.*, 
                u.nama AS nama_peminjam, 
                r.nama_ruang,
                r.lokasi
            FROM {$this->table} p
            JOIN users u ON p.user_id = u.user_id
            JOIN ruang r ON p.ruang_id = r.ruang_id
            WHERE p.peminjaman_id = :id
        ";

        $this->db->query($query);
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    // -------------------------------
    // 3. Setujui peminjaman oleh admin
    // -------------------------------
    public function approveAdmin($id)
    {
        $query = "UPDATE {$this->table} SET status = 'disetujui' WHERE peminjaman_id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount(); // optional: return affected rows
    }

    // -------------------------------
    // 4. Tolak peminjaman oleh admin
    // -------------------------------
    public function rejectAdmin($id, $alasan)
    {
        $query = "
            UPDATE {$this->table} 
            SET status = 'ditolak', alasan_admin = :alasan 
            WHERE peminjaman_id = :id
        ";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->bind('alasan', $alasan);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // -------------------------------
    // 5. (Opsional) Ambil daftar permintaan pengembalian
    // -------------------------------
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
