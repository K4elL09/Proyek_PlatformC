<?php

namespace App\Controllers;
use App\Models\ProdukModel;

class Home extends BaseController {
    public function index() {
        $this->cekLogin();
        $produkModel = new ProdukModel();
        $data['produk'] = $produkModel->findAll();
        return view('produk_list', $data);
    }
    
    private function cekLogin() {
        if (!session()->get('id_pengguna')) {
            return redirect()->to('/login')->send();
        }
    }
}