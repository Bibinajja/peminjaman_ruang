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

    public function add($data)
    {
        $query = "INSERT INTO ruang (nama_ruang, kapasitas, lokasi, deskripsi)
                  VALUES (:nama_ruang, :kapasitas, :lokasi, :deskripsi)";

        $this->db->query($query);
        $this->db->bind(':nama_ruang', $data['nama_ruang']);
        $this->db->bind(':kapasitas', $data['kapasitas']);
        $this->db->bind(':lokasi', $data['lokasi']);
        $this->db->bind(':deskripsi', $data['deskripsi']);

        return $this->db->execute();
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM ruang WHERE ruang_id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
