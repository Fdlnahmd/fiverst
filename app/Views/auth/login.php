<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="card glass-panel p-5 anim-fade-up" style="max-width: 420px; width: 100%; border-radius: 20px;">
        <div class="text-center mb-4">
            <h2 class="text-uppercase mb-1"><span class="gold-text">LOGIN</span></h2>
            <p class="text-secondary small">Five Star Restaurant Portal</p>
        </div>

        <?php if (isset($error) && $error): ?>
            <div class="alert alert-danger border-0 small text-center" style="border-radius: 30px; background-color: rgba(220, 53, 69, 0.15); color: #ff6b70;">
                <i class="fa-solid fa-triangle-exclamation me-1"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/login">
            <!-- Email Input -->
            <div class="mb-4">
                <label for="email" class="form-label text-secondary small">Email</label>
                <div class="input-group">
                    <span class="input-group-text border-0 bg-transparent text-secondary" style="margin-right: -40px; z-index: 10 !important; position: relative;"><i class="fa-solid fa-envelope"></i></span>
                    <input type="email" class="form-control form-glass w-100" id="email" name="email" placeholder="Masukkan email" style="padding-left: 45px;" required>
                </div>
            </div>

            <!-- Password Input -->
            <div class="mb-4">
                <label for="password" class="form-label text-secondary small">Password</label>
                <div class="input-group">
                    <span class="input-group-text border-0 bg-transparent text-secondary" style="margin-right: -40px; z-index: 10 !important; position: relative;"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" class="form-control form-glass w-100" id="password" name="password" maxlength="8" placeholder="Masukkan password" style="padding-left: 45px;" required>
                </div>
            </div>

            <!-- Action buttons -->
            <button type="submit" class="btn btn-gold w-100 py-3 mb-3 text-uppercase"><i class="fa-solid fa-right-to-bracket me-2"></i> Masuk</button>
            
            <p class="text-center text-secondary small mb-0">
                Belum punya akun? <a href="/register" class="text-decoration-none" style="color: var(--accent-crimson); font-weight: 600;">Daftar di sini</a>
            </p>
        </form>
    </div>
</div>
