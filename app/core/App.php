<?php

class App
{
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseURL();

        // 1. Controller - Cek khusus untuk 'profil' dulu
        if (isset($url[0]) && $url[0] === 'profil') {
            $this->controller = 'Profil'; // Set controller jadi Profil
            unset($url[0]); // Hapus 'profil' dari URL

            // Require controller Profil
            if (file_exists('../app/controller/Profil.php')) {
                require_once '../app/controller/Profil.php';
            } else {
                die("Controller Profil.php tidak ditemukan!");
            }

            $this->controller = new $this->controller; // Instansiasi

            // 2. Method - cek apakah ada 'update'
            if (isset($url[1]) && $url[1] === 'update') {
                $this->method = 'update';
                unset($url[1]);
            }

            // Sisa parameter (jika ada)
            if (!empty($url)) {
                $this->params = array_values($url);
            }

            // Langsung eksekusi, karena sudah ditentukan
            call_user_func_array([$this->controller, $this->method], $this->params);
            return; // Penting! Agar tidak lanjut ke logic default di bawah
        }

        // === LOGIC DEFAULT UNTUK CONTROLLER LAIN ===
        // 1. Controller default
        if (isset($url[0])) {
            if (file_exists('../app/controller/' . ucfirst($url[0]) . '.php')) {
                $this->controller = ucfirst($url[0]);
                unset($url[0]);
            }
        }

        require_once '../app/controller/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // 2. Method
        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        // 3. Parameter
        if (!empty($url)) {
            $this->params = array_values($url);
        }

        // 4. Eksekusi
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseURL()
    {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}