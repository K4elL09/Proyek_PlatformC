<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
    <div class="form-container">
        <h2>Login</h2>
        <form method="post" action="<?= site_url('auth/doLogin') ?>">
            <?= csrf_field() ?>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit" class="btn" style="width: 100%;">Login</button>
            
            <?php if (session('error')): ?>
                <p class="error-message"><?= session('error') ?></p>
            <?php endif; ?>
        </form>

        <p class="form-footer-link">
            Belum punya akun? <a href="<?= site_url('register') ?>">Daftar di sini</a>
        </p>
    </div>
<?= $this->endSection() ?>