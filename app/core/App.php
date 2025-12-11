<?php

class App {
    // Controller Default (Halaman pertama kali dibuka)
    protected $controller = 'Home'; 
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseURL();

        // 1. Cek Controller
        // Mencari file controller di folder app/controller/
        if (isset($url[0]) && file_exists('../app/controller/' . ucfirst($url[0]) . '.php')) {
            $this->controller = ucfirst($url[0]);
            unset($url[0]);
        }

    
        require_once '../app/controller/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // 2. Cek Method
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // 3. Kelola Params
        if (!empty($url)) {
            $this->params = array_values($url);
        }

        // Jalankan Controller & Method, serta kirimkan params jika ada
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    // Fungsi untuk memecah URL
    public function parseURL()
    {
        if (isset($_GET['url'])) {
            // Hapus tanda slash di akhir url
            $url = rtrim($_GET['url'], '/');
            // Bersihkan url dari karakter aneh
            $url = filter_var($url, FILTER_SANITIZE_URL);
            // Pecah url berdasarkan tanda slash
            $url = explode('/', $url);
            return $url;
        }
        return []; // Kembalikan array kosong jika tidak ada URL
    }
}