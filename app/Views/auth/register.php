<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh; padding: 40px 0;">
    <div class="card glass-panel p-5 anim-fade-up" style="max-width: 480px; width: 100%; border-radius: 20px;">
        <div class="text-center mb-4">
            <h2 class="text-uppercase mb-1"><span class="gold-text">REGISTER</span></h2>
            <p class="text-secondary small">Buat akun Five Star untuk mulai memesan</p>
        </div>

        <?php if (isset($error) && $error): ?>
            <div class="alert alert-danger border-0 small text-center" style="border-radius: 30px; background-color: rgba(220, 53, 69, 0.15); color: #ff6b70;">
                <i class="fa-solid fa-triangle-exclamation me-1"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/register">
            <!-- Full Name Input -->
            <div class="mb-3">
                <label for="nama_lengkap" class="form-label text-secondary small">Nama Lengkap</label>
                <input type="text" class="form-control form-glass w-100" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama lengkap" required>
            </div>

            <!-- Email Input -->
            <div class="mb-3">
                <label for="email" class="form-label text-secondary small">Email</label>
                <input type="email" class="form-control form-glass w-100" id="email" name="email" placeholder="Masukkan email" required>
            </div>

            <!-- Password Input -->
            <div class="mb-3">
                <label for="password" class="form-label text-secondary small">Password (Max 8 karakter)</label>
                <input type="password" class="form-control form-glass w-100" id="password" name="password" maxlength="8" placeholder="Buat password" required>
            </div>

            <!-- Handphone Input -->
            <div class="mb-3">
                <label for="hp" class="form-label text-secondary small">Nomor HP</label>
                <input type="text" class="form-control form-glass w-100" id="hp" name="hp" placeholder="Masukkan nomor handphone" required>
            </div>

            <!-- Address Input -->
            <div class="mb-4">
                <label for="alamat" class="form-label text-secondary small">Alamat</label>
                <textarea class="form-control form-glass w-100" id="alamat" name="alamat" rows="2" placeholder="Masukkan alamat lengkap" required></textarea>
            </div>

            <!-- Action buttons -->
            <button type="submit" class="btn btn-gold w-100 py-3 mb-3 text-uppercase"><i class="fa-solid fa-user-plus me-2"></i> Daftar Sekarang</button>
            
            <p class="text-center text-secondary small mb-0">
                Sudah punya akun? <a href="/login" class="text-decoration-none" style="color: var(--accent-crimson); font-weight: 600;">Login di sini</a>
            </p>
        </form>
    </div>
</div>
