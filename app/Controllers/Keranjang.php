<?php 

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\PenggunaModel;
use App\Models\TransaksiModel;
use App\Models\DetailTransaksiModel;

class Keranjang extends BaseController
{
    public function tambah($id_produk) {
        $keranjang = session()->get('keranjang') ?? [];
        if (isset($keranjang[$id_produk])) {
            $keranjang[$id_produk]++;
        } else {
            $keranjang[$id_produk] = 1;
        }
        session()->set('keranjang', $keranjang);
        return redirect()->to('/');
    }

    public function lihat() {
        $produkModel = new ProdukModel();
        $keranjang = session()->get('keranjang') ?? [];
        $data = [];
        $data['items'] = [];
        $total = 0;
        foreach ($keranjang as $id => $qty) {
            $produk = $produkModel->find($id);
            if ($produk) {
                $subtotal = $produk['harga'] * $qty;
                $data['items'][] = [
                    'produk' => $produk,
                    'jumlah' => $qty,
                    'subtotal' => $subtotal
                ];
                $total += $subtotal;
            }
        }
        $data['total'] = $total;
        return view('keranjang', $data);
    }

    public function checkout()
    {
        $keranjang = session()->get('keranjang') ?? [];
        if (empty($keranjang)) return redirect()->to('/');

        $penggunaModel = new PenggunaModel();
        $produkModel = new ProdukModel();

        $data['pengguna'] = $penggunaModel->find(session()->get('id_pengguna'));

        $ids_produk = array_keys($keranjang);
        $produk_di_keranjang = $produkModel->whereIn('id_produk', $ids_produk)->findAll();
        
        $data['items'] = [];
        $subtotal_produk = 0;
        foreach ($produk_di_keranjang as $p) {
            $qty = $keranjang[$p['id_produk']];
            $data['items'][] = [
                'produk' => $p,
                'jumlah' => $qty
            ];
            $subtotal_produk += $p['harga'] * $qty;
        }
        $data['subtotal_produk'] = $subtotal_produk;

        $data['opsi_pengiriman'] = [
            ['nama' => 'Hemat Kargo', 'harga' => 34000, 'estimasi' => '9 - 12 Jun'],
            ['nama' => 'Reguler', 'harga' => 44000, 'estimasi' => '8 - 11 Jun'],
            ['nama' => 'Instant', 'harga' => 75000, 'estimasi' => 'Hari ini']
        ];
        $data['metode_pembayaran'] = [
            'Transfer Bank - BRI',
            'Transfer Bank - BCA',
            'COD (Bayar di Tempat)',
        ];

        return view('checkout_page', $data);
    }

    public function prosesPesanan()
    {
        $keranjang = session()->get('keranjang') ?? [];
        if (empty($keranjang)) return redirect()->to('/');

        $postData = $this->request->getPost();

        $db = \Config\Database::connect();
        $db->transStart();

        $transaksiModel = new TransaksiModel();
        $produkModel = new ProdukModel();
        
        $subtotal_produk = 0;
        $ids_produk = array_keys($keranjang);
        $produk_di_keranjang = $produkModel->whereIn('id_produk', $ids_produk)->findAll();
        foreach($produk_di_keranjang as $p) {
            $subtotal_produk += $p['harga'] * $keranjang[$p['id_produk']];
        }

        $biaya_pengiriman = (float) $postData['biaya_pengiriman'];
        $total_pembayaran = $subtotal_produk + $biaya_pengiriman;

        $id_transaksi = $transaksiModel->insert([
            'id_pengguna'         => session()->get('id_pengguna'),
            'alamat_pengiriman'   => $postData['alamat_pengiriman'],
            'opsi_pengiriman'     => $postData['opsi_pengiriman'],
            'biaya_pengiriman'    => $biaya_pengiriman,
            'metode_pembayaran'   => $postData['metode_pembayaran'],
            'total_harga_semua'   => $total_pembayaran,
            'status_pembayaran'   => 'Belum Dibayar',
        ], true);

        $detailModel = new DetailTransaksiModel();
        foreach ($keranjang as $id => $qty) {
            $produk = $produkModel->find($id);
            $detailModel->insert([
                'id_transaksi'   => $id_transaksi,
                'id_produk'      => $id,
                'jumlah_beli'    => $qty,
                'subtotal_harga' => $produk['harga'] * $qty
            ]);
        }

        $db->transComplete();
        session()->remove('keranjang');
        session()->setFlashdata('success_message', 'Pesanan Berhasil Dibuat! Silakan lihat riwayat transaksi Anda untuk detail pembayaran.');
        return redirect()->to('/');
    }
}