<?php

class Database
{
    private $host = 'localhost';
    private $user = 'root';
    private $pass = ''; 
    private $db_name = 'db_sistem_peminjaman'; 

    private $dbh; // Database Handler
    private $stmt; // Statement

    public function __construct()
    {
        // Data Source Name (DSN)
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db_name;

        $option = [
            PDO::ATTR_PERSISTENT => true, // Menjaga koneksi tetap terjaga
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // Mode error
        ];

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $option);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // Fungsi untuk mempersiapkan query
    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    // Fungsi untuk binding data (mencegah SQL Injection)
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    // Eksekusi query
    public function execute()
    {
        $this->stmt->execute();
    }

    // Ambil banyak data (untuk tabel/list)
    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ambil satu data (untuk detail/login)
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Hitung baris yang terpengaruh (untuk cek insert/update/delete berhasil atau tidak)
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
}
