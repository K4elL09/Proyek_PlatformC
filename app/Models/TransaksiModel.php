<?php
namespace App\Models;
use CodeIgniter\Model;

class TransaksiModel extends Model {
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $allowedFields = [
        'id_pengguna', 
        'alamat_pengiriman', 
        'opsi_pengiriman',
        'biaya_pengiriman',
        'metode_pembayaran',
        //'tanggal_transaksi',
        'status_pembayaran', 
        'total_harga_semua'
    ];
    //protected $useTimestamps = true;
    //protected $createdField = 'tanggal_transaksi';
    //public $timestamps = true;
}