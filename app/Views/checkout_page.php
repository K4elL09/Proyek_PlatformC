<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <h2>Checkout</h2>

    <form method="post" action="<?= site_url('keranjang/prosesPesanan') ?>">
        <div class="checkout-grid">
            <div class="checkout-main">
                <div class="checkout-section">
                    <h4>Alamat Pengiriman</h4>
                    <div class="address-box">
                        <strong><?= $pengguna['nama_lengkap'] ?> (+62<?= substr($pengguna['no_telepon'], 1) ?>)</strong>
                        <p><?= $pengguna['alamat'] ?></p>
                        <input type="hidden" name="alamat_pengiriman" value="<?= esc($pengguna['alamat']) ?>">
                    </div>
                </div>

                <div class="checkout-section">
                    <h4>Produk Dipesan</h4>
                    <?php foreach($items as $item): ?>
                    <div class="product-checkout-item">
                        <img src="<?= base_url('images/' . $item['produk']['gambar']) ?>" alt="<?= $item['produk']['nama'] ?>">
                        <div class="product-info">
                            <p class="product-name"><?= $item['produk']['nama'] ?></p>
                            <p class="product-qty">x <?= $item['jumlah'] ?></p>
                        </div>
                        <p class="product-price">Rp <?= number_format($item['produk']['harga'] * $item['jumlah']) ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="checkout-section">
                    <h4>Opsi Pengiriman</h4>
                    <?php foreach($opsi_pengiriman as $index => $opsi): ?>
                    <div class="option-item">
                        <input type="radio" name="opsi_pengiriman" id="opsi-<?= $index ?>" value="<?= $opsi['nama'] ?>" data-harga="<?= $opsi['harga'] ?>" <?= $index === 0 ? 'checked' : '' ?>>
                        <label for="opsi-<?= $index ?>">
                            <div>
                                <strong><?= $opsi['nama'] ?></strong>
                                <p class="estimasi">Estimasi tiba: <?= $opsi['estimasi'] ?></p>
                            </div>
                            <span class="option-price">Rp <?= number_format($opsi['harga']) ?></span>
                        </label>
                    </div>
                    <?php endforeach; ?>
                    <input type="hidden" name="biaya_pengiriman" id="biaya_pengiriman" value="<?= $opsi_pengiriman[0]['harga'] ?>">
                </div>
            </div>

            <div class="checkout-sidebar">
                <div class="checkout-section">
                    <h4>Metode Pembayaran</h4>
                    <select name="metode_pembayaran" class="payment-select">
                    <?php foreach($metode_pembayaran as $metode): ?>
                        <option value="<?= $metode ?>"><?= $metode ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>

                <div class="checkout-section">
                    <h4>Rincian Pembayaran</h4>
                    <div class="payment-summary">
                        <div>
                            <span>Subtotal Produk</span>
                            <span id="summary-subtotal">Rp <?= number_format($subtotal_produk) ?></span>
                        </div>
                        <div>
                            <span>Biaya Pengiriman</span>
                            <span id="summary-pengiriman">Rp <?= number_format($opsi_pengiriman[0]['harga']) ?></span>
                        </div>
                        <hr>
                        <div class="total-payment">
                            <span>Total Pembayaran</span>
                            <span id="summary-total">Rp <?= number_format($subtotal_produk + $opsi_pengiriman[0]['harga']) ?></span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success" style="width: 100%;">Buat Pesanan</button>
            </div>
        </div>
    </form>

    <style>
        .checkout-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; }
        .checkout-section { background: #fff; border: 1px solid #eee; border-radius: 5px; padding: 20px; margin-bottom: 20px; }
        .address-box, .product-checkout-item { display: flex; align-items: center; gap: 15px; }
        .product-checkout-item img { width: 50px; height: 50px; object-fit: cover; border-radius: 5px; }
        .product-info { flex-grow: 1; }
        .product-name, .product-qty { margin: 0; }
        .product-price { font-weight: bold; }
        .option-item { margin-bottom: 10px; }
        .option-item label { display: flex; justify-content: space-between; align-items: center; border: 1px solid #ccc; padding: 15px; border-radius: 5px; cursor: pointer; }
        .option-item input[type="radio"] { display: none; }
        .option-item input[type="radio"]:checked + label { border-color: #007bff; background-color: #f0f8ff; }
        .option-price { font-weight: bold; color: #333; }
        .estimasi { font-size: 0.9em; color: #666; margin: 0; }
        .payment-select { width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc; }
        .payment-summary > div { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .payment-summary .total-payment { font-weight: bold; font-size: 1.2em; }
        @media (max-width: 992px) { .checkout-grid { grid-template-columns: 1fr; } }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const subtotalProduk = <?= $subtotal_produk ?>;
            const pengirimanRadios = document.querySelectorAll('input[name="opsi_pengiriman"]');
            
            const summaryPengiriman = document.getElementById('summary-pengiriman');
            const summaryTotal = document.getElementById('summary-total');
            const biayaPengirimanInput = document.getElementById('biaya_pengiriman');

            pengirimanRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    const biaya = parseFloat(this.dataset.harga);
                    const total = subtotalProduk + biaya;

                    summaryPengiriman.textContent = 'Rp ' + biaya.toLocaleString('id-ID');
                    summaryTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');
                    biayaPengirimanInput.value = biaya;
                });
            });
        });
    </script>
<?= $this->endSection() ?>