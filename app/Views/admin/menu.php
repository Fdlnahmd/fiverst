<?php
/** @var array $productsByCategory */
if (!isset($productsByCategory)) {
    $productsByCategory = [];
}
?>
<div class="container my-5 anim-fade-up">
    <div class="text-center mb-5">
        <h1 class="text-uppercase gold-text">Kelola Daftar Menu</h1>
        <p class="text-secondary small">Panel Kelola Produk Five Star Restaurant</p>
    </div>

    <!-- Add Product Button Trigger -->
    <div class="text-center mb-5">
        <a href="/admin/menu/add" class="btn btn-gold px-4 py-3 text-uppercase"><i class="fa-solid fa-plus me-1"></i> Tambah Daftar Menu</a>
    </div>

    <!-- Category Selector Navigation -->
    <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
        <button type="button" class="filter-btn btn btn-gold btn-sm" data-filter="all" style="border-radius: 20px; transition: all 0.3s;">
            ALL
        </button>
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
        ?>
        <?php foreach ($productsByCategory as $categoryName => $products): ?>
            <?php if (!empty($products)): ?>
                <?php 
                $targetId = $idMap[$categoryName] ?? 'menu';
                ?>
                <button type="button" class="filter-btn btn btn-outline-secondary btn-sm" data-filter="<?= $targetId ?>" style="border-radius: 20px; border-color: var(--border-color); color: var(--text-primary); transition: all 0.3s;">
                    <?= htmlspecialchars($categoryName) ?>
                </button>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- Category Groups -->
    <?php foreach ($productsByCategory as $categoryName => $products): ?>
        <?php if (!empty($products)): ?>
            <?php 
            $targetId = $idMap[$categoryName] ?? 'menu';
            ?>
            <div class="menu-category-group" data-category="<?= $targetId ?>">
                <div class="category-title-container text-center mt-5 mb-4">
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
                                    
                                    <!-- Product culinary description -->
                                    <div class="flex-grow-1">
                                        <p class="text-secondary small mb-3"><?= htmlspecialchars($row['deskripsi'] ?? 'Hidangan istimewa khas resep rahasia Five Star Restaurant.') ?></p>
                                    </div>

                                    <p class="card-text mb-4 text-danger fw-bold" style="color: var(--accent-crimson) !important;">
                                        Rp <?= number_format($row['harga_menu']) ?>
                                    </p>
                                    <div class="mt-auto d-flex gap-2">
                                        <a href="/admin/menu/edit?id=<?= $row['id'] ?>" class="btn btn-gold btn-sm flex-grow-1 text-center"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                        <button type="button" class="btn-delete-menu btn btn-crimson btn-sm flex-grow-1 text-center" data-id="<?= $row['id'] ?>" data-name="<?= htmlspecialchars($row['nama_menu']) ?>" style="color: white !important;"><i class="fa-solid fa-trash"></i> Hapus</button>
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
            this.style.color = '#ffffff';

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
                    if (titleContainer) titleContainer.style.display = 'block';
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

    // Programmatically click "ALL" on load to initialize view state
    const allButton = document.querySelector('.filter-btn[data-filter="all"]');
    if (allButton) {
        allButton.click();
    }

    // SweetAlert2 Delete Confirmation for Admin Menu
    const deleteButtons = document.querySelectorAll('.btn-delete-menu');
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            
            Swal.fire({
                title: 'Hapus Hidangan?',
                text: `Apakah Anda yakin ingin menghapus hidangan "${name}" dari daftar menu?`,
                icon: 'warning',
                showCancelButton: true,
                background: isDark ? '#172414' : '#E4EDE0',
                color: isDark ? '#E8F5EC' : '#1E3020',
                confirmButtonColor: '#C1603A',
                cancelButtonColor: isDark ? 'rgba(255, 255, 255, 0.15)' : 'rgba(0, 0, 0, 0.15)',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                iconColor: '#C1603A',
                customClass: {
                    confirmButton: 'swal2-confirm',
                    cancelButton: 'swal2-cancel'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/admin/menu/delete?id=${id}`;
                }
            });
        });
    });
});
</script>

<style>
.swal2-confirm, .swal2-cancel {
    font-weight: 600 !important;
    letter-spacing: 0.5px !important;
    border-radius: 30px !important;
    padding: 10px 24px !important;
}
.swal2-cancel {
    color: var(--text-primary) !important;
}
</style>
