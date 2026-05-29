<div class="container my-5 anim-fade-up" style="min-height: 70vh;">
    <div class="text-center mb-5">
        <h1 class="text-uppercase gold-text">Daftar Pesanan Masuk</h1>
        <p class="text-secondary small">Panel Transaksi Five Star Restaurant</p>
    </div>

    <?php if (empty($orders)): ?>
        <div class="text-center p-5 glass-panel" style="border-radius: 16px; max-width: 500px; margin: 0 auto;">
            <i class="fa-solid fa-receipt fs-1 text-secondary mb-3"></i>
            <h5 class="mb-3 text-uppercase">Belum Ada Pesanan</h5>
            <p class="text-secondary small mb-0">Semua pesanan yang dikonfirmasi oleh pembeli akan muncul di sini.</p>
        </div>
    <?php else: ?>
        <div class="glass-panel p-4" style="border-radius: 16px; overflow-x: auto;">
            <table class="table align-middle" style="color: var(--text-primary);">
                <thead>
                    <tr style="border-bottom: 2px solid var(--border-color);">
                        <th scope="col" style="font-family: var(--font-heading); letter-spacing: 1px;">No</th>
                        <th scope="col" style="font-family: var(--font-heading); letter-spacing: 1px;">ID Pemesanan</th>
                        <th scope="col" style="font-family: var(--font-heading); letter-spacing: 1px;">Tanggal Transaksi</th>
                        <th scope="col" style="font-family: var(--font-heading); letter-spacing: 1px;">Total Pembayaran</th>
                        <th scope="col" style="font-family: var(--font-heading); letter-spacing: 1px; text-align: center;">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $nomor = 1; ?>
                    <?php foreach ($orders as $row): ?>
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <td><?= $nomor++ ?></td>
                            <td><span class="badge bg-secondary font-monospace" style="font-size: 0.95rem; border-radius: 6px;">#<?= $row['id_pemesanan'] ?></span></td>
                            <td><?= date("d M Y", strtotime($row['tanggal_pemesanan'])) ?></td>
                            <td><strong class="gold-text">Rp <?= number_format($row['total_belanja']) ?></strong></td>
                            <td align="center">
                                <button type="button" class="btn-delete-order btn btn-crimson btn-sm" data-id="<?= $row['id_pemesanan'] ?>" style="border-radius: 20px;">
                                    <i class="fa-solid fa-trash-can me-1"></i> Hapus Data
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.btn-delete-order');
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('data-id');
            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            
            Swal.fire({
                title: 'Hapus Pesanan?',
                text: `Apakah Anda yakin ingin menghapus data pesanan #${id}? Tindakan ini bersifat permanen.`,
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
                    window.location.href = `/admin/orders/delete?id=${id}`;
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
