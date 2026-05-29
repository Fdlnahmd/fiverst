<div class="container my-5 anim-fade-up" style="max-width: 600px;">
    <div class="card glass-panel p-5" style="border-radius: 20px;">
        <div class="text-center mb-4">
            <h2 class="text-uppercase mb-1"><span class="gold-text">Tambah Menu Baru</span></h2>
            <p class="text-secondary small">Masukkan informasi hidangan baru Anda</p>
        </div>

        <?php if (isset($error) && $error): ?>
            <div class="alert alert-danger border-0 small text-center" style="border-radius: 30px; background-color: rgba(220, 53, 69, 0.15); color: #ff6b70;">
                <i class="fa-solid fa-triangle-exclamation me-1"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/admin/menu/add" enctype="multipart/form-data">
            <!-- Product Name Input -->
            <div class="mb-4">
                <label for="nama_menu" class="form-label text-secondary small">Nama Menu</label>
                <input type="text" class="form-control form-glass w-100" id="nama_menu" name="nama_menu" placeholder="Masukkan nama hidangan" required>
            </div>

            <!-- Product Price Input -->
            <div class="mb-4">
                <label for="harga_menu" class="form-label text-secondary small">Harga Menu (Rp)</label>
                <input type="number" class="form-control form-glass w-100" id="harga_menu" name="harga_menu" placeholder="Masukkan harga (angka saja)" required>
            </div>

            <!-- Product Category Select -->
            <div class="mb-4">
                <label for="kategori" class="form-label text-secondary small">Kategori</label>
                <select class="form-select form-glass w-100" id="kategori" name="kategori" required>
                    <option value="" disabled selected>Pilih kategori menu</option>
                    <option value="CHICKEN">CHICKEN</option>
                    <option value="PORK">PORK</option>
                    <option value="TOFU & OMELETTE">TOFU & OMELETTE</option>
                    <option value="FISH">FISH</option>
                    <option value="SEAFOOD">SEAFOOD</option>
                    <option value="VEGETABLES">VEGETABLES</option>
                    <option value="SOUP, RICE, & NOODLES">SOUP, RICE, & NOODLES</option>
                    <option value="DESSERTS & BEVERAGES">DESSERTS & BEVERAGES</option>
                </select>
            </div>

            <!-- Product Description Input -->
            <div class="mb-4">
                <label for="deskripsi" class="form-label text-secondary small">Deskripsi Hidangan</label>
                <textarea class="form-control form-glass w-100" id="deskripsi" name="deskripsi" rows="3" placeholder="Masukkan cerita lezat atau deskripsi hidangan ini..." required></textarea>
            </div>

            <!-- File Upload Input (FIXED: Missing in original code) -->
            <div class="mb-4">
                <label for="gambar" class="form-label text-secondary small">Foto Menu</label>
                <input type="file" class="form-control form-glass w-100" id="gambar" name="gambar" accept="image/*" required>
                <div class="form-text text-secondary small mt-1">Gunakan format gambar JPG, JPEG, atau PNG.</div>
            </div>

            <!-- Action buttons -->
            <div class="d-flex gap-3 mt-5">
                <a href="/admin/menu" class="btn btn-outline-secondary flex-grow-1 text-center py-3" style="border-radius: 30px; border-color: var(--border-color); color: var(--text-primary);"><i class="fa-solid fa-arrow-left"></i> Batal</a>
                <button type="submit" class="btn btn-gold flex-grow-1 py-3 text-uppercase"><i class="fa-solid fa-cloud-arrow-up me-1"></i> Simpan Menu</button>
            </div>
        </form>
    </div>
</div>
