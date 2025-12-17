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
    // GET USER BY ID
    // =========================

    public function getUserById($id)
    {
        $this->db->query("SELECT user_id, nama, email, role FROM {$this->table} WHERE user_id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
// Update profil user
    public function updateProfil($user_id, $nama, $email, $password = '')
    {
        try {
            if (!empty($password)) {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $query = "UPDATE users SET nama = :nama, email = :email, password = :password WHERE user_id = :user_id";
                $this->db->query($query);
                $this->db->bind(':password', $hashed);
            } else {
                $query = "UPDATE users SET nama = :nama, email = :email WHERE user_id = :user_id";
                $this->db->query($query);
            }

            $this->db->bind(':nama', $nama);
            $this->db->bind(':email', $email);
            $this->db->bind(':user_id', $user_id);

            $this->db->execute();

            if ($this->db->rowCount() > 0) {
                return ['success' => true];
            } else {
                return ['success' => false, 'message' => 'Tidak ada perubahan atau email sudah digunakan!'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Gagal update: ' . $e->getMessage()];
        }
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
