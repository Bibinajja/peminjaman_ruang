<?php

class App
{
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseURL();

        // 1. Controller
        if (isset($url[0])) {
            if (file_exists('../app/controller/' . ucfirst($url[0]) . '.php')) {
                $this->controller = ucfirst($url[0]);
                unset($url[0]);
            }
        }

        require_once '../app/controller/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // 🔥 2. METHOD (DI SINI TEMPATNYA)
        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        // 🔒 GUARD TAMBAHAN (INI YANG KAMU TANYA)
        if (!method_exists($this->controller, $this->method)) {
            $this->method = 'index';
        }

        // 3. PARAMETER
        if (!empty($url)) {
            $this->params = array_values($url);
        }

        // 4. EKSEKUSI
        call_user_func_array(
            [$this->controller, $this->method],
            $this->params
        );
    }

    public function parseURL()
    {
        if (isset($_GET['url'])) {
            return explode('/', rtrim($_GET['url'], '/'));
        }
    }
}
