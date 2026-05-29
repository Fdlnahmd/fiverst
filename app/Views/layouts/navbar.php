<?php
$isLoggedIn = isset($_SESSION['login_user']);
$role = $_SESSION['user_role'] ?? null;
$logoLink = '/';

if ($isLoggedIn) {
    if ($role === 'admin') {
        $logoLink = '/admin';
    } else {
        $logoLink = '/user';
    }
}
?>
<div id="top"></div>

<nav class="navbar navbar-expand-xl fixed-top glass-navbar py-2">
    <div class="container">
        <!-- Logo Brand -->
        <a class="navbar-brand d-flex align-items-center" href="<?= $logoLink ?>">
            <img src="/assets/photo/FS_wordmark.png" alt="Five Star Logo" height="52" class="d-inline-block align-text-top">
        </a>

        <!-- Responsive Toggle Button -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#fiverstNavbar" aria-controls="fiverstNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="fiverstNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-xl-0">
                <?php if ($isLoggedIn && $role === 'admin'): ?>
                    <!-- ADMIN LINKS -->
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="/admin"><i class="fa-solid fa-list-check me-1"></i> Transaksi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="/admin/menu"><i class="fa-solid fa-utensils me-1"></i> Kelola Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="/admin/menu/add"><i class="fa-solid fa-plus me-1"></i> Tambah Menu</a>
                    </li>
                <?php elseif ($isLoggedIn && $role === 'user'): ?>
                    <!-- USER LINKS -->
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="/user#top"><i class="fa-solid fa-house me-1"></i> Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="/user#about-us"><i class="fa-solid fa-circle-info me-1"></i> Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="/user#franchise"><i class="fa-solid fa-store me-1"></i> Kemitraan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="/user/menu"><i class="fa-solid fa-utensils me-1"></i> Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="/cart"><i class="fa-solid fa-cart-shopping me-1"></i> Keranjang</a>
                    </li>
                <?php else: ?>
                    <!-- GUEST LINKS -->
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="/home#top"><i class="fa-solid fa-house me-1"></i> Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="/home#about-us"><i class="fa-solid fa-circle-info me-1"></i> Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="/home#franchise"><i class="fa-solid fa-store me-1"></i> Kemitraan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="/menu"><i class="fa-solid fa-utensils me-1"></i> Menu</a>
                    </li>
                <?php endif; ?>
            </ul>

            <!-- Theme Toggle and Auth Buttons -->
            <div class="d-flex align-items-center gap-3">
                <!-- Theme Toggle Switcher -->
                <button type="button" class="theme-toggle-btn" id="theme-toggle" title="Toggle Light/Dark Theme">
                    <i class="fa-solid fa-sun text-warning"></i>
                </button>

                <?php if ($isLoggedIn): ?>
                    <span class="text-secondary small d-none d-md-inline">Halo, <strong class="gold-text"><?= htmlspecialchars($_SESSION['login_user']) ?></strong></span>
                    <a href="/logout" class="btn btn-crimson btn-sm"><i class="fa-solid fa-right-from-bracket me-1"></i> Logout</a>
                <?php else: ?>
                    <a href="/login" class="btn btn-gold btn-sm"><i class="fa-solid fa-right-to-bracket me-1"></i> Login</a>
                    <a href="/register" class="btn btn-crimson btn-sm"><i class="fa-solid fa-user-plus me-1"></i> Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- Push content below fixed navbar -->
<div style="height: 90px;"></div>
