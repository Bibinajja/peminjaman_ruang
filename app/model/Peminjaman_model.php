<?php

class Peminjaman_model
{
    private $table = 'peminjaman';
    private $pk = 'peminjaman_id';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function add($data)
    {
        $query = "INSERT INTO peminjaman
        (user_id, ruang_id, tanggal_mulai, tanggal_selesai, keperluan, status)
        VALUES (:user_id, :ruang_id, :tm, :ts, :kep, :status)";

        $this->db->query($query);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':ruang_id', $data['ruang_id']);
        $this->db->bind(':tm', $data['tanggal_mulai']);
        $this->db->bind(':ts', $data['tanggal_selesai']);
        $this->db->bind(':kep', $data['keperluan']);
        $this->db->bind(':status', $data['status']);
        return $this->db->execute();
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
    // 5. Konfirmasi warek
    // -------------------------------

    public function getTahapWarek()
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
        FROM peminjaman p
        JOIN users u ON p.user_id = u.user_id
        JOIN ruang r ON p.ruang_id = r.ruang_id
        WHERE p.status = 'konfirmasi_admin'
        ORDER BY p.peminjaman_id DESC
    ";

        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function approveWarek($id)
{
    $this->db->query("
        UPDATE peminjaman 
        SET status = 'konfirmasi_warek' 
        WHERE peminjaman_id = :id
    ");
    $this->db->bind(':id', $id);
    return $this->db->execute();
}
    public function rejectWarek($id, $alasan)
    {
        $this->db->query("
            UPDATE peminjaman 
            SET status = 'ditolak',
            alasan_warek = :alasan 
            WHERE peminjaman_id = :id
        ");
        $this->db->bind(':id', $id);
        $this->db->bind(':alasan', $alasan);
        return $this->db->execute();
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

public function getByUser($user_id)
{
    $this->db->query("
        SELECT p.*, r.nama_ruang, u.nama AS nama_peminjam 
        FROM peminjaman p 
        JOIN ruang r ON p.ruang_id = r.ruang_id 
        JOIN users u ON p.user_id = u.user_id
        WHERE p.user_id = :user_id 
        ORDER BY p.peminjaman_id DESC
    ");
    $this->db->bind(':user_id', $user_id);
    return $this->db->resultSet();
}

public function cekKonflik($ruang_id, $mulai, $selesai)
{
    $this->db->query("
        SELECT COUNT(*) as total FROM peminjaman
        WHERE ruang_id = :ruang_id
        AND status IN ('pending', 'disetujui', 'konfirmasi_admin', 'konfirmasi_warek')
        AND (
            (tanggal_mulai < :selesai AND tanggal_selesai > :mulai)
        )
    ");
    $this->db->bind(':ruang_id', $ruang_id);
    $this->db->bind(':mulai', $mulai);
    $this->db->bind(':selesai', $selesai);
    
    $result = $this->db->single();
    return $result['total'] > 0;
}
}
