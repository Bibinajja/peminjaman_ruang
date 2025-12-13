<?php

class Controller
{
    // Method View
    // Parameter: $view (nama file view), $data (data yang dikirim ke view)
    public function view($view, $data = [])
    {

        // Cek apakah file view ada
        if (file_exists('../app/view/' . $view . '.php')) {
            require_once '../app/view/' . $view . '.php';
        } else {
            // Opsional: Error handling jika view tidak ditemukan
            die("View '$view' tidak ditemukan.");
        }
    }

    // Method Model
    public function model($model)
    {
        // Cek apakah file model ada
        if (file_exists('../app/model/' . $model . '.php')) {
            require_once '../app/model/' . $model . '.php';
            // Instansiasi model
            return new $model;
        } else {
            die("Model '$model' tidak ditemukan.");
        }
    }
}
