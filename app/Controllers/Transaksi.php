<?php namespace App\Controllers;

use App\Models\TransaksiModel;

class Transaksi extends BaseController 
{
    public function index() 
    {
        $id = session()->get('id_pengguna');
        $transaksiModel = new TransaksiModel();
        $data['transaksi'] = $transaksiModel->where('id_pengguna', $id)->orderBy('tanggal_transaksi', 'DESC')->findAll();
        return view('transaksi_list', $data);
    }

    public function konfirmasi($id_transaksi)
    {
        $transaksiModel = new TransaksiModel();
        $id_pengguna_session = session()->get('id_pengguna');

        $transaksi = $transaksiModel
            ->where('id_transaksi', $id_transaksi)
            ->where('id_pengguna', $id_pengguna_session)
            ->first();

        if ($transaksi) {
            $data_update = [
                'status_pembayaran' => 'Lunas'
            ];

            $transaksiModel->update($id_transaksi, $data_update);

            session()->setFlashdata('success_message', 'Pembayaran untuk Transaksi #' . $id_transaksi . ' berhasil dikonfirmasi!');
        } else {
            session()->setFlashdata('error_message', 'Transaksi tidak valid.');
        }

        return redirect()->to('/transaksi');
    }
}