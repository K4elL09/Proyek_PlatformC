<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <h2>Daftar Produk</h2>

    <div class="product-grid">
        <?php foreach ($produk as $p): ?>
            <div class="product-card">
                <img src="<?= base_url('images/' . $p['gambar']) ?>" alt="<?= $p['nama'] ?>">
                <div class="product-card-body">
                    <h3><?= $p['nama'] ?></h3>
                    <p><?= $p['deskripsi'] ?></p>
                    <p class="price">Rp <?= number_format($p['harga']) ?></p>
                    <a href="<?= site_url('keranjang/tambah/' . $p['id_produk']) ?>" class="btn">Tambah ke Keranjang</a>
                </div>
            </div>
        <?php endforeach ?>
    </div>
<?= $this->endSection() ?>