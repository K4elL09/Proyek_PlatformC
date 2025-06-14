<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
    <div class="form-container">
        <h2>Buat Akun Baru</h2>

        <?php if(session('errors')): ?>
            <div class="alert alert-danger">
                <p><strong>Mohon perbaiki kesalahan berikut:</strong></p>
                <ul>
                <?php foreach (session('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
                </ul>
            </div>
        <?php endif ?>

        <form method="post" action="<?= site_url('auth/doRegister') ?>">
            <?= csrf_field() ?>
            
            <label for="nama_lengkap">Nama Lengkap:</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?= old('nama_lengkap') ?>" required>
            
            <label for="alamat">Alamat Lengkap:</label>
            <textarea id="alamat" name="alamat" required rows="4"><?= old('alamat') ?></textarea>
            
            <label for="no_telepon">No. Telepon:</label>
            <input type="text" id="no_telepon" name="no_telepon" value="<?= old('no_telepon') ?>" required>
            
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?= old('username') ?>" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit" class="btn btn-success" style="width: 100%;">Daftar</button>
        </form>
        
        <p class="form-footer-link">
            Sudah punya akun? <a href="<?= site_url('login') ?>">Login di sini</a>
        </p>
    </div>
<?= $this->endSection() ?>