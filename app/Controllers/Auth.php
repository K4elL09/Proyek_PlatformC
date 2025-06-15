<?php namespace App\Controllers;

use App\Models\PenggunaModel;

class Auth extends BaseController {
    
    public function login() {
        return view('login');
    }

    public function doLogin() {
        $model = new PenggunaModel();
        $username = $this->request->getPost('username');
        $password = (string) $this->request->getPost('password');

        $user = $model->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set('id_pengguna', $user['id_pengguna']);
            return redirect()->to('/');
        }
        
        return redirect()->back()->with('error', 'Username atau Password salah');
    }

    public function logout() {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function register()
    {
        return view('register');
    }

    public function doRegister()
    {
        $rules = [
            'nama_lengkap' => 'required|min_length[3]',
            'alamat'       => 'required|min_length[10]',
            'no_telepon'   => 'required|numeric|min_length[10]',
            'username'     => 'required|min_length[5]|is_unique[pengguna.username]',
            'password'     => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'alamat'       => $this->request->getPost('alamat'),
            'no_telepon'   => $this->request->getPost('no_telepon'),
            'username'     => $this->request->getPost('username'),
            'password'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ];

        $model = new PenggunaModel();
        $model->insert($data);

        session()->setFlashdata('success_message', 'Registrasi berhasil! Silakan login dengan akun baru Anda.');
        return redirect()->to('/login');
    }
}