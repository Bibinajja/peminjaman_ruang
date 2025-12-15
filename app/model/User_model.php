<?php

class User_model
{

    // public function login($username, $password)
    // {
    //     // contoh return
    //     return [
    //         'username' => $username,
    //         'role' => 'peminjam'
    //     ];
    // }

    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    public function getUserByEmail($email)
    {
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind(':email', $email);
        return $this->db->single();
    }

    // public function login($email, $password)
    // {
    //     $this->db->query("SELECT * FROM users WHERE email = :email");
    //     $this->db->bind(':email', $email);
    //     $user = $this->db->single();

    //     if (!$user) {
    //         return false;
    //     }

    //     if ($password !== $user['password']) {
    //         return false;
    //     }

    //     return $user;
    // }

    // 📝 Register user
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
        $user = $this->getUserByEmail($email);

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        return $user;
    }

    
    

}
