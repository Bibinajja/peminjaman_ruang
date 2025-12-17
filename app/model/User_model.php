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
    // UPDATE USER
    // =========================
    public function update($data)
    {
        $query = "UPDATE {$this->table}
                  SET nama = :nama,
                      email = :email,
                      role = :role
                  WHERE user_id = :id";

        $this->db->query($query);
        $this->db->bind('id', $data['id']);
        $this->db->bind('nama', $data['username']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('role', $data['role']);

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

    public function getUserByEmail($email)
    {
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind(':email', $email);
        return $this->db->single();
    }


    public function register($data)
    {
        $query = "INSERT INTO users (nama, email, password, created_at)
                  VALUES (:nama, :email, :password, NOW())";

        $this->db->query($query);
        $this->db->bind(':nama', $data['nama']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        return $this->db->execute();
    }

    // 🔐 Login (FIX LOGIC)
    public function login($email, $password)
    {
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind('email', $email);
        $user = $this->db->single();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }
}
