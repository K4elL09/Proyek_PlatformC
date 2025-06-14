<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <h2>Riwayat Transaksi</h2>

    <?php if (empty($transaksi)): ?>
        <p>Anda belum memiliki riwayat transaksi.</p>
    <?php else: ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Tanggal</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Tindakan</th> </tr>
            </thead>
            <tbody>
                <?php foreach ($transaksi as $t): ?>
                    <tr>
                        <td>#<?= $t['id_transaksi'] ?></td>
                        <td><?= date('d M Y H:i', strtotime($t['tanggal_transaksi'])) ?></td>
                        <td>Rp <?= number_format($t['total_harga_semua']) ?></td>
                        <td>
                            <span class="status <?= strtolower(str_replace(' ', '-', $t['status_pembayaran'])) ?>">
                                <?= $t['status_pembayaran'] ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($t['status_pembayaran'] == 'Belum Dibayar'): ?>
                                <a href="<?= site_url('transaksi/konfirmasi/' . $t['id_transaksi']) ?>" class="btn btn-success" style="padding: 5px 10px; font-size: 0.9em;">
                                    Konfirmasi Pembayaran
                                </a>
                            <?php else: ?>
                                <span>✔ Lunas</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif; ?>

    <style>
        .status {
            padding: 3px 8px;
            border-radius: 15px;
            color: #fff;
            font-size: 0.85em;
            font-weight: bold;
        }
        .status.belum-dibayar {
            background-color: #dc3545;
        }
        .status.lunas {
            background-color: #28a745;
        }
    </style>

<?= $this->endSection() ?>