<div class="container my-5 anim-fade-up" style="min-height: 70vh;">
    <div class="text-center mb-5">
        <h1 class="text-uppercase gold-text">Keranjang Belanja</h1>
        <p class="text-secondary small">Tinjau pesanan lezat Anda sebelum konfirmasi</p>
    </div>

    <?php if (empty($cartItems)): ?>
        <div class="text-center p-5 glass-panel" style="border-radius: 16px; max-width: 500px; margin: 0 auto;">
            <i class="fa-solid fa-cart-shopping fs-1 text-secondary mb-3"></i>
            <h5 class="mb-3 text-uppercase">Keranjang Anda Kosong</h5>
            <p class="text-secondary small mb-4">Silakan pilih makanan terlebih dahulu dari daftar menu kami.</p>
            <a href="/user/menu" class="btn btn-gold"><i class="fa-solid fa-utensils me-1"></i> Lihat Menu</a>
        </div>
    <?php else: ?>
        <div class="glass-panel p-4 mb-4" style="border-radius: 16px; overflow-x: auto;">
            <table class="table align-middle" style="color: var(--text-primary);">
                <thead>
                    <tr style="border-bottom: 2px solid var(--border-color);">
                        <th scope="col" style="font-family: var(--font-heading); letter-spacing: 1px;">No</th>
                        <th scope="col" style="font-family: var(--font-heading); letter-spacing: 1px;">Nama Hidangan</th>
                        <th scope="col" style="font-family: var(--font-heading); letter-spacing: 1px;">Harga</th>
                        <th scope="col" style="font-family: var(--font-heading); letter-spacing: 1px;">Jumlah</th>
                        <th scope="col" style="font-family: var(--font-heading); letter-spacing: 1px;">Subharga</th>
                        <th scope="col" style="font-family: var(--font-heading); letter-spacing: 1px; text-align: center;">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $nomor = 1; 
                    $totalbelanja = 0;
                    ?>
                    <?php foreach ($cartItems as $item): ?>
                        <?php 
                        $subharga = $item['product']['harga_menu'] * $item['qty'];
                        $totalbelanja += $subharga;
                        ?>
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <td><?= $nomor++ ?></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="/assets/upload/<?= htmlspecialchars($item['product']['gambar']) ?>" alt="" width="50" height="50" style="object-fit: cover; border-radius: 8px; border: 1px solid var(--border-color);">
                                    <strong><?= htmlspecialchars($item['product']['nama_menu']) ?></strong>
                                </div>
                            </td>
                            <td>Rp <?= number_format($item['product']['harga_menu']) ?></td>
                            <td>
                                <span class="badge px-3 py-2 fs-6" style="border-radius: 10px; background-color: var(--bg-secondary); color: var(--text-primary); border: 1px solid var(--border-color);"><?= $item['qty'] ?></span>
                            </td>
                            <td><strong class="gold-text">Rp <?= number_format($subharga) ?></strong></td>
                            <td align="center">
                                <a href="/cart/remove?id_menu=<?= $item['product']['id'] ?>" class="btn btn-outline-danger btn-sm border-0" style="border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;" title="Hapus Item">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="fs-5 fw-bold" style="border-top: 2px solid var(--border-color);">
                        <td colspan="4" class="text-uppercase" style="font-family: var(--font-heading);">Total Belanja</td>
                        <td colspan="2"><span class="gold-text">Rp <?= number_format($totalbelanja) ?></span></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Action Form -->
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="d-flex gap-2 flex-wrap">
                <a href="/user/menu" class="btn btn-outline-secondary" style="border-radius: 30px; border-color: var(--border-color); color: var(--text-primary);"><i class="fa-solid fa-arrow-left me-1"></i> Kembali Belanja</a>
                <button type="button" id="btn-clear-cart" class="btn btn-outline-danger" style="border-radius: 30px; border-color: rgba(220, 53, 69, 0.45); color: #ff6b70;"><i class="fa-solid fa-trash-can me-1"></i> Kosongkan Keranjang</button>
            </div>
            
            <form method="POST" action="/cart">
                <button type="submit" class="btn btn-gold py-3 px-5 text-uppercase"><i class="fa-solid fa-circle-check me-2"></i> Konfirmasi Pesanan</button>
            </form>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const clearBtn = document.getElementById('btn-clear-cart');
            if (clearBtn) {
                clearBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
                    
                    Swal.fire({
                        title: 'Kosongkan Keranjang?',
                        text: 'Semua hidangan lezat pilihan Anda akan dihapus dari keranjang belanja.',
                        icon: 'warning',
                        showCancelButton: true,
                        background: isDark ? '#172414' : '#E4EDE0',
                        color: isDark ? '#E8F5EC' : '#1E3020',
                        confirmButtonColor: '#C1603A',
                        cancelButtonColor: isDark ? 'rgba(255, 255, 255, 0.15)' : 'rgba(0, 0, 0, 0.15)',
                        confirmButtonText: 'Ya, Kosongkan!',
                        cancelButtonText: 'Batal',
                        iconColor: '#C1603A',
                        customClass: {
                            confirmButton: 'swal2-confirm',
                            cancelButton: 'swal2-cancel'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '/cart/clear';
                        }
                    });
                });
            }
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
    <?php endif; ?>
</div>
