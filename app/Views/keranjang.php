<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <h2>Keranjang Belanja</h2>

    <?php if (empty($items)): ?>
        <p>Keranjang belanja Anda masih kosong.</p>
    <?php else: ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th colspan="2">Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td style="width: 70px;">
                        <img src="<?= base_url('images/' . $item['produk']['gambar']) ?>" alt="<?= $item['produk']['nama'] ?>">
                    </td>
                    <td><?= $item['produk']['nama'] ?></td>
                    <td>Rp <?= number_format($item['produk']['harga']) ?></td>
                    <td><?= $item['jumlah'] ?></td>
                    <td>Rp <?= number_format($item['subtotal']) ?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>

        <div class="cart-total">
            <strong>Total: Rp <?= number_format($total) ?></strong>
        </div>

        <div class="cart-actions">
            <a href="<?= site_url('checkout') ?>" class="btn btn-success">Lanjutkan ke Checkout</a>
        </div>
    <?php endif; ?>

<?= $this->endSection() ?>