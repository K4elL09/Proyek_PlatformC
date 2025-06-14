<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dapur Platform</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>

    <nav class="navbar">
        <a href="<?= site_url('/') ?>" class="brand">Dapur Platform</a>
        <div class="nav-links">
            <?php if(session()->get('id_pengguna')): ?>
                <a href="<?= site_url('keranjang/lihat') ?>">Keranjang</a>
                <a href="<?= site_url('transaksi') ?>">Transaksi Saya</a>
                <a href="<?= site_url('auth/logout') ?>">Logout</a>
            <?php else: ?>
                <a href="<?= site_url('login') ?>">Login</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="container">
        
        <?php if (session()->getFlashdata('success_message')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success_message') ?>
                <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
            </div>
        <?php endif; ?>
        
        <?= $this->renderSection('content') ?>
    </div>

</body>
</html>