<div class="container my-5 anim-fade-up" style="max-width: 600px;">
    <div class="card glass-panel p-5" style="border-radius: 20px;">
        <div class="text-center mb-4">
            <h2 class="text-uppercase mb-1"><span class="gold-text">Edit Menu</span></h2>
            <p class="text-secondary small">Perbarui detail hidangan Fiverst Anda</p>
        </div>

        <?php if (isset($error) && $error): ?>
            <div class="alert alert-danger border-0 small text-center" style="border-radius: 30px; background-color: rgba(220, 53, 69, 0.15); color: #ff6b70;">
                <i class="fa-solid fa-triangle-exclamation me-1"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/admin/menu/edit" enctype="multipart/form-data">
            <input type="hidden" name="id_menu" value="<?= $product['id'] ?>">

            <!-- Product Name Input -->
            <div class="mb-4">
                <label for="nama_menu" class="form-label text-secondary small">Nama Menu</label>
                <input type="text" class="form-control form-glass w-100" id="nama_menu" name="nama_menu" value="<?= htmlspecialchars($product['nama_menu']) ?>" placeholder="Masukkan nama hidangan" required>
            </div>

            <!-- Product Price Input -->
            <div class="mb-4">
                <label for="harga_menu" class="form-label text-secondary small">Harga Menu (Rp)</label>
                <input type="number" class="form-control form-glass w-100" id="harga_menu" name="harga_menu" value="<?= htmlspecialchars($product['harga_menu']) ?>" placeholder="Masukkan harga" required>
            </div>

            <!-- Product Category Select -->
            <div class="mb-4">
                <label for="kategori" class="form-label text-secondary small">Kategori</label>
                <select class="form-select form-glass w-100" id="kategori" name="kategori" required>
                    <?php 
                    $cats = ['CHICKEN', 'PORK', 'TOFU & OMELETTE', 'FISH', 'SEAFOOD', 'VEGETABLES', 'SOUP, RICE, & NOODLES', 'DESSERTS & BEVERAGES'];
                    foreach ($cats as $cat):
                        $selected = ($product['kategori'] === $cat) ? 'selected' : '';
                    ?>
                        <option value="<?= $cat ?>" <?= $selected ?>><?= $cat ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Product Description Input -->
            <div class="mb-4">
                <label for="deskripsi" class="form-label text-secondary small">Deskripsi Hidangan</label>
                <textarea class="form-control form-glass w-100" id="deskripsi" name="deskripsi" rows="3" placeholder="Masukkan cerita lezat atau deskripsi hidangan ini..." required><?= htmlspecialchars($product['deskripsi'] ?? '') ?></textarea>
            </div>

            <!-- Current Image Preview -->
            <div class="mb-4">
                <label class="form-label text-secondary small d-block">Foto Saat Ini</label>
                <img src="/assets/upload/<?= htmlspecialchars($product['gambar']) ?>" alt="" width="120" height="120" style="object-fit: cover; border-radius: 12px; border: 1px solid var(--border-color);" class="mb-3">
                
                <label for="gambar" class="form-label text-secondary small d-block">Ganti Foto (Opsional)</label>
                <input type="file" class="form-control form-glass w-100" id="gambar" name="gambar" accept="image/*">
                <div class="form-text text-secondary small mt-1">Kosongkan jika Anda tidak ingin memperbarui foto.</div>
            </div>

            <!-- Action buttons -->
            <div class="d-flex gap-3 mt-5">
                <a href="/admin/menu" class="btn btn-outline-secondary flex-grow-1 text-center py-3" style="border-radius: 30px; border-color: var(--border-color); color: var(--text-primary);"><i class="fa-solid fa-arrow-left"></i> Batal</a>
                <button type="submit" class="btn btn-gold flex-grow-1 py-3 text-uppercase"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
