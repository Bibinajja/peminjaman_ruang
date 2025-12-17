<?php

class Pengembalian_model
{
    private $table = 'Pengembalian';
    private $pk = 'Pengembalian_id';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

// -------------------------------
    // 5. (Opsional) Ambil daftar permintaan pengembalian
    // -------------------------------
    public function getPengembalian()
{
    $query = "
        SELECT 
            peng.pengembalian_id,          -- ID dari tabel pengembalian
            p.peminjaman_id,               -- ID peminjaman
            u.nama AS peminjam,
            r.nama_ruang AS ruang,
            p.tanggal_mulai,
            p.tanggal_selesai,
            alasan_penolakan_admin,                   -- alasan dari tabel pengembalian
            tanggal_pengembalian         -- optional: kapan diajukan
        FROM {$this->table} peng
        JOIN peminjaman p ON peng.peminjaman_id = p.peminjaman_id
        JOIN users u ON p.user_id = u.user_id
        JOIN ruang r ON p.ruang_id = r.ruang_id
        WHERE peng.status = 'menunggu'     -- atau 'pending' sesuai kolom status di tabel pengembalian
        ORDER BY tanggal_pengembalian DESC
    ";

    $this->db->query($query);
    return $this->db->resultSet();
}

    /**
     * Setujui pengembalian
     */
    public function approvePengembalian($id)
{
    $query = "UPDATE {$this->table} SET status = 'selesai' WHERE {$this->pk} = :id";
    $this->db->query($query);
    $this->db->bind('id', $id);
    $this->db->execute();
    return $this->db->rowCount();
}

public function rejectPengembalian($id, $reason)
{
    $query = "UPDATE {$this->table} 
              SET status = 'ditolak', alasan_admin = :reason 
              WHERE {$this->pk} = :id";
    $this->db->query($query);
    $this->db->bind('id', $id);
    $this->db->bind('reason', $reason);
    $this->db->execute();
    return $this->db->rowCount();
}
}