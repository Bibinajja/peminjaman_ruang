<?php

class User_model
{
    private $table = 'users';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // =========================
    // GET ALL USERS
    // =========================
    public function getAll()
    {
        $this->db->query("SELECT user_id, nama, email, role FROM {$this->table}");
        return $this->db->resultSet();
    }

    // =========================
    // GET USER BY ID (PENTING untuk Profil)
    // =========================
    public function getById($id)
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE user_id = :id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    // =========================
    // TAMBAH USER (ADD)
    // =========================
    public function add($data)
    {
        // Kita masukkan Role juga disini
        $query = "INSERT INTO users (nama, email, password, role, created_at)
                  VALUES (:nama, :email, :password, :role, NOW())";

        $this->db->query($query);
        $this->db->bind('nama', $data['nama']);
        $this->db->bind('email', $data['email']);

        // Enkripsi password sebelum simpan agar aman & bisa login
        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->db->bind('password', $hashed_password);

        $this->db->bind('role', $data['role']);

        return $this->db->execute();
    }

    // =========================
    // EDIT USER (EDIT)
    // =========================
    public function edit($data)
    {
        // Cek apakah password diisi? Jika ya, update password juga.
        if (!empty($data['password'])) {
            $query = "UPDATE {$this->table} 
                      SET nama = :nama, 
                          email = :email, 
                          role = :role, 
                          password = :password 
                      WHERE user_id = :id";
        } else {
            // Jika password kosong, jangan ubah password yang lama
            $query = "UPDATE {$this->table} 
                      SET nama = :nama, 
                          email = :email, 
                          role = :role 
                      WHERE user_id = :id";
        }

        $this->db->query($query);

        // PERBAIKAN: Menggunakan $data['nama'], bukan $data['username']
        $this->db->bind('nama', $data['nama']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('role', $data['role']);
        $this->db->bind('id', $data['id']);

        // Bind password hanya jika ada
        if (!empty($data['password'])) {
            $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
            $this->db->bind('password', $hashed_password);
        }

        return $this->db->execute();
    }

    // =========================
    // DELETE USER
    // =========================
    public function delete($id)
    {
        $this->db->query("DELETE FROM {$this->table} WHERE user_id = :id");
        $this->db->bind('id', $id);
        return $this->db->execute();
    }

    // =========================
    // CEK EMAIL & LOGIN
    // =========================
    public function getUserByEmail($email)
    {
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind('email', $email);
        return $this->db->single();
    }

    public function login($email, $password)
    {
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind('email', $email);
        $user = $this->db->single();

        // Pastikan password diverifikasi dengan hash
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }
}
