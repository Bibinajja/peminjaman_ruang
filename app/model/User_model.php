<?php

class User_model {

    public function login($username, $password)
    {
        // contoh return
        return [
            'username' => $username,
            'role' => 'peminjam'
        ];
    }
}
