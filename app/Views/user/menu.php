<?php
/** @var array $productsByCategory */
if (!isset($productsByCategory)) {
    $productsByCategory = [];
}
?>
<div class="container my-5 anim-fade-up">
    <div class="text-center mb-5">
        <h1 class="text-uppercase gold-text">Daftar Menu</h1>
        <p class="text-secondary small">Halo Pembeli! Silakan pilih hidangan lezat Anda</p>
    </div>

    <!-- Category Navigator -->
    <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
        <button type="button" class="btn btn-gold btn-sm filter-btn" data-filter="all" style="border-radius: 20px; transition: all 0.3s;">
            ALL
        </button>
        <?php foreach ($productsByCategory as $categoryName => $products): ?>
            <?php if (!empty($products)): ?>
                <?php 
                $idMap = [
                    'CHICKEN' => 'chicken',
                    'PORK' => 'pork',
                    'TOFU & OMELETTE' => 'omelette',
                    'FISH' => 'fish',
                    'SEAFOOD' => 'seafood',
                    'VEGETABLES' => 'vegetables',
                    'SOUP, RICE, & NOODLES' => 'srn',
                    'DESSERTS & BEVERAGES' => 'dnb'
                ];
                $targetId = $idMap[$categoryName] ?? 'menu';
                ?>
                <button type="button" class="btn btn-outline-secondary btn-sm filter-btn" data-filter="<?= $targetId ?>" style="border-radius: 20px; border-color: var(--border-color); color: var(--text-primary); transition: all 0.3s;">
                    <?= htmlspecialchars($categoryName) ?>
                </button>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- Grouped Menu Lists -->
    <?php foreach ($productsByCategory as $categoryName => $products): ?>
        <?php if (!empty($products)): ?>
            <?php 
            $targetId = $idMap[$categoryName] ?? 'menu';
            ?>
            <div class="menu-category-group" data-category="<?= $targetId ?>">
                <div id="<?= $targetId ?>" style="padding-top: 100px; margin-top: -100px;"></div>
                <div class="text-center mt-5 mb-4 category-title-container">
                    <h3 class="category-title-border text-uppercase gold-text"><?= htmlspecialchars($categoryName) ?></h3>
                </div>
                
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4 mb-5">
                    <?php foreach ($products as $row): ?>
                        <div class="col">
                            <div class="premium-card h-100 d-flex flex-column">
                                <div style="overflow: hidden; height: 200px;">
                                    <img src="/assets/upload/<?= htmlspecialchars($row['gambar']) ?>" class="card-img-top w-100 h-100" alt="<?= htmlspecialchars($row['nama_menu']) ?>" style="object-fit: cover;">
                                </div>
                                <div class="card-body d-flex flex-column p-4">
                                    <h5 class="card-title fs-6 mb-2"><?= htmlspecialchars($row['nama_menu']) ?></h5>
                                    <p class="card-text mb-2 text-danger fw-bold" style="color: var(--accent-crimson) !important;">
                                        Rp <?= number_format($row['harga_menu']) ?>
                                    </p>
                                    <p class="card-description small text-secondary mb-3 flex-grow-1" style="font-size: 0.78rem; line-height: 1.4; color: var(--text-secondary) !important;">
                                        <?= htmlspecialchars($row['deskripsi'] ?? 'Hidangan istimewa racikan bumbu rahasia warisan turun-temurun Five Star Restaurant.') ?>
                                    </p>
                                    <div class="mt-auto">
                                        <a href="/cart/add?kd_produk=<?= $row['id']; ?>" class="btn btn-gold btn-sm w-100"><i class="fa-solid fa-cart-plus me-1"></i> Beli</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const categoryGroups = document.querySelectorAll('.menu-category-group');

    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Reset all buttons to inactive styling
            filterButtons.forEach(b => {
                b.classList.remove('btn-gold');
                b.classList.add('btn-outline-secondary');
                b.style.color = 'var(--text-primary)';
            });

            // Set clicked button to active styling
            this.classList.remove('btn-outline-secondary');
            this.classList.add('btn-gold');
            this.style.color = '';

            const filterValue = this.getAttribute('data-filter');

            // Toggle category lists visibility with smooth fade-in
            categoryGroups.forEach(group => {
                const titleContainer = group.querySelector('.category-title-container');
                const productsRow = group.querySelector('.row');

                if (filterValue === 'all') {
                    group.style.display = 'block';
                    if (titleContainer) titleContainer.style.display = 'none'; // Hide category title in ALL mode
                    if (productsRow) {
                        productsRow.classList.remove('mb-5');
                        productsRow.classList.add('mb-4');
                    }
                    group.style.opacity = '0';
                    setTimeout(() => {
                        group.style.transition = 'opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
                        group.style.opacity = '1';
                    }, 50);
                } else if (group.getAttribute('data-category') === filterValue) {
                    group.style.display = 'block';
                    if (titleContainer) titleContainer.style.display = 'block'; // Show category title when filtered
                    if (productsRow) {
                        productsRow.classList.remove('mb-4');
                        productsRow.classList.add('mb-5');
                    }
                    group.style.opacity = '0';
                    setTimeout(() => {
                        group.style.transition = 'opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
                        group.style.opacity = '1';
                    }, 50);
                } else {
                    group.style.display = 'none';
                }
            });
        });
    });

    // Check if URL hash exists and maps to an active category filter button on load
    const hash = window.location.hash.substring(1);
    let initialFilter = 'all';
    if (hash) {
        const targetBtn = document.querySelector(`.filter-btn[data-filter="${hash}"]`);
        if (targetBtn) {
            initialFilter = hash;
        }
    }
    
    // Programmatically click the initial filter button
    const initialButton = document.querySelector(`.filter-btn[data-filter="${initialFilter}"]`);
    if (initialButton) {
        initialButton.click();
    }

    // Listen to hashchange events for seamless in-page navigation filtering
    window.addEventListener('hashchange', function() {
        const newHash = window.location.hash.substring(1);
        if (newHash) {
            const targetBtn = document.querySelector(`.filter-btn[data-filter="${newHash}"]`);
            if (targetBtn) {
                targetBtn.click();
            }
        } else {
            const allBtn = document.querySelector('.filter-btn[data-filter="all"]');
            if (allBtn) {
                allBtn.click();
            }
        }
    });

    // Intercept "Beli" clicks to append the currently active filter
    const buyButtons = document.querySelectorAll('.mt-auto a.btn-gold');
    buyButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const activeBtn = document.querySelector('.filter-btn.btn-gold');
            const activeFilter = activeBtn ? activeBtn.getAttribute('data-filter') : 'all';
            const baseHref = this.getAttribute('href');
            window.location.href = baseHref + '&from_filter=' + activeFilter;
        });
    });
});
</script>

<?php if (isset($_SESSION['cart_success'])): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    const productName = <?= json_encode($_SESSION['cart_success']) ?>;
    
    // Choose beautiful color tokens matching our restored Giok theme!
    const bgColor = isDark ? '#172414' : '#E4EDE0';
    const textColor = isDark ? '#E8F5EC' : '#1E3020';
    
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true,
        background: bgColor,
        color: textColor,
        iconColor: '#C1603A',
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    Toast.fire({
        icon: 'success',
        title: productName + ' dimasukkan ke keranjang!'
    });
});
</script>
<?php unset($_SESSION['cart_success']); ?>
<?php endif; ?>
