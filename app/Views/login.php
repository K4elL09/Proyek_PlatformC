<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <div class="login-form">
        <h2>Login</h2>
        <form method="post" action="<?= site_url('auth/doLogin') ?>">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit" class="btn" style="width: 100%;">Login</button>
            
            <?php if (session('error')): ?>
                <p class="error"><?= session('error') ?></p>
            <?php endif; ?>
        </form>
    </div>
<?= $this->endSection() ?>