<?php
namespace App\Controllers;
use App\Models\PenggunaModel;

class Auth extends BaseController {
    public function login() {
        return view('login');
    }

    public function doLogin() {
        $model = new PenggunaModel();
        $user = $model->where('username', $this->request->getPost('username'))
                      ->where('password', $this->request->getPost('password'))
                      ->first();
        if ($user) {
            session()->set('id_pengguna', $user['id_pengguna']);
            return redirect()->to('/');
        }
        return redirect()->back()->with('error', 'Login gagal');
    }

    public function logout() {
        session()->destroy();
        return redirect()->to('/login');
    }
}