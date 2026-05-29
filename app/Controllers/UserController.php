<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;
use App\Models\Order;

class UserController extends Controller
{
    private Product $productModel;
    private Order $orderModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->orderModel = new Order();
    }

    public function index(): void
    {
        $this->checkAuth('user');
        $this->view('user/home', ['title' => 'Home - Five Star Restaurant']);
    }

    public function menu(): void
    {
        $this->checkAuth('user');

        $products = $this->productModel->getAll();

        // Preset categories list
        $categories = [
            'CHICKEN' => [],
            'PORK' => [],
            'TOFU & OMELETTE' => [],
            'FISH' => [],
            'SEAFOOD' => [],
            'VEGETABLES' => [],
            'SOUP, RICE, & NOODLES' => [],
            'DESSERTS & BEVERAGES' => []
        ];

        // Group products into category buckets
        foreach ($products as $row) {
            $cat = strtoupper($row['kategori']);
            if (array_key_exists($cat, $categories)) {
                $categories[$cat][] = $row;
            }
        }

        $this->view('user/menu', [
            'title' => 'Daftar Menu - Five Star Restaurant',
            'productsByCategory' => $categories
        ]);
    }

    public function cartAdd(): void
    {
        $this->checkAuth('user');

        $kd_produk = (int)($_GET['kd_produk'] ?? 0);
        $categoryHash = '';

        if ($kd_produk > 0) {
            $product = $this->productModel->getById($kd_produk);
            if ($product) {
                if (!isset($_SESSION['pesanan'])) {
                    $_SESSION['pesanan'] = [];
                }

                if (isset($_SESSION['pesanan'][$kd_produk])) {
                    $_SESSION['pesanan'][$kd_produk]++;
                } else {
                    $_SESSION['pesanan'][$kd_produk] = 1;
                }
                
                // Set flash session for success notification
                $_SESSION['cart_success'] = $product['nama_menu'];

                // Map product category to correct URL hash to preserve filter!
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
                $catUpper = strtoupper($product['kategori']);
                $categoryHash = $idMap[$catUpper] ?? '';
            }
        }

        $redirectUrl = '/user/menu';
        if ($categoryHash !== '') {
            $redirectUrl .= '#' . $categoryHash;
        }

        $this->redirect($redirectUrl);
    }

    public function cartRemove(): void
    {
        $this->checkAuth('user');

        $id_menu = (int)($_GET['id_menu'] ?? 0);

        if ($id_menu > 0 && isset($_SESSION['pesanan'][$id_menu])) {
            unset($_SESSION['pesanan'][$id_menu]);
        }

        $this->redirect('/cart');
    }

    public function cartClear(): void
    {
        $this->checkAuth('user');

        if (isset($_SESSION['pesanan'])) {
            unset($_SESSION['pesanan']);
        }

        $this->redirect('/cart');
    }

    public function cart(): void
    {
        $this->checkAuth('user');

        $cartSession = $_SESSION['pesanan'] ?? [];
        $cartItems = [];

        foreach ($cartSession as $id_menu => $qty) {
            $product = $this->productModel->getById($id_menu);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'qty'     => $qty
                ];
            }
        }

        $this->view('user/cart', [
            'title' => 'Keranjang Belanja - Five Star Restaurant',
            'cartItems' => $cartItems
        ]);
    }

    public function cartConfirm(): void
    {
        $this->checkAuth('user');

        $cartSession = $_SESSION['pesanan'] ?? [];
        if (empty($cartSession)) {
            $this->redirect('/cart');
        }

        // Calculate grand total
        $totalBelanja = 0;
        foreach ($cartSession as $id_menu => $qty) {
            $product = $this->productModel->getById($id_menu);
            if ($product) {
                $totalBelanja += $product['harga_menu'] * $qty;
            }
        }

        // Store to DB via Transaction
        $success = $this->orderModel->createOrder($cartSession, $totalBelanja);

        if ($success) {
            // Clear cart session
            unset($_SESSION['pesanan']);
            
            // Redirect with a beautiful theme-aware SweetAlert2 pop-up
            echo "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Konfirmasi Pesanan - Five Star Restaurant</title>
                <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css' />
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <style>
                    body {
                        background-color: #0F1A14;
                        font-family: sans-serif;
                        transition: background-color 0.4s ease;
                    }
                    /* Custom SweetAlert buttons style */
                    .swal2-confirm {
                        font-weight: 600 !important;
                        letter-spacing: 1px !important;
                        text-transform: uppercase !important;
                        border-radius: 30px !important;
                        padding: 12px 30px !important;
                    }
                </style>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const savedTheme = localStorage.getItem('fiverst_theme') || 'dark';
                        const isDark = savedTheme === 'dark';
                        
                        // Dynamically update body background to match theme instantly!
                        document.body.style.backgroundColor = isDark ? '#0F1A14' : '#F4F7F2';
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Pemesanan Sukses!',
                            text: 'Hidangan bintang lima Anda sedang disiapkan.',
                            background: isDark ? '#172414' : '#E4EDE0',
                            color: isDark ? '#E8F5EC' : '#1E3020',
                            confirmButtonColor: '#C1603A',
                            confirmButtonText: 'OK',
                            iconColor: '#C1603A',
                            buttonsStyling: true,
                            customClass: {
                                confirmButton: 'swal2-confirm'
                            }
                        }).then(() => {
                            window.location.href = '/user/menu';
                        });
                    });
                </script>
            </head>
            <body></body>
            </html>";
            exit;
        } else {
            // Redirect with a beautiful theme-aware SweetAlert2 pop-up
            echo "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Pemesanan Gagal - Five Star Restaurant</title>
                <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css' />
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <style>
                    body {
                        background-color: #0F1A14;
                        font-family: sans-serif;
                        transition: background-color 0.4s ease;
                    }
                    /* Custom SweetAlert buttons style */
                    .swal2-confirm {
                        font-weight: 600 !important;
                        letter-spacing: 1px !important;
                        text-transform: uppercase !important;
                        border-radius: 30px !important;
                        padding: 12px 30px !important;
                    }
                </style>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const savedTheme = localStorage.getItem('fiverst_theme') || 'dark';
                        const isDark = savedTheme === 'dark';
                        
                        // Dynamically update body background to match theme instantly!
                        document.body.style.backgroundColor = isDark ? '#0F1A14' : '#F4F7F2';
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Pemesanan Gagal',
                            text: 'Gagal memproses pesanan! Silakan coba lagi.',
                            background: isDark ? '#172414' : '#E4EDE0',
                            color: isDark ? '#E8F5EC' : '#1E3020',
                            confirmButtonColor: '#C1603A',
                            confirmButtonText: 'Coba Lagi',
                            iconColor: '#C1603A',
                            buttonsStyling: true,
                            customClass: {
                                confirmButton: 'swal2-confirm'
                            }
                        }).then(() => {
                            window.location.href = '/cart';
                        });
                    });
                </script>
            </head>
            <body></body>
            </html>";
            exit;
        }
    }
}
