<div class="container error-page-container anim-fade-up">
    <div class="error-code">404</div>
    <h2 class="mb-3 text-uppercase">Halaman Tidak Ditemukan</h2>
    <p class="text-secondary max-width-500 mx-auto mb-5">
        Maaf, halaman yang Anda cari tidak tersedia atau telah dipindahkan. Silakan kembali ke beranda untuk menikmati kuliner ayam kampung terbaik kami.
    </p>
    
    <?php
    $homeUrl = '/';
    if (isset($_SESSION['login_user'])) {
        if ($_SESSION['user_role'] === 'admin') {
            $homeUrl = '/admin';
        } else {
            $homeUrl = '/user';
        }
    }
    ?>
    
    <a href="<?= $homeUrl ?>" class="btn btn-gold px-5 py-3">
        <i class="fa-solid fa-house me-2"></i> Kembali ke Beranda
    </a>
</div>

<style>
.max-width-500 {
    max-width: 500px;
}
</style>
