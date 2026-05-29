<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;
use App\Models\Order;

class AdminController extends Controller
{
    private Product $productModel;
    private Order $orderModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->orderModel = new Order();
    }

    public function orders(): void
    {
        $this->checkAuth('admin');

        $orders = $this->orderModel->getAll();

        $this->view('admin/orders', [
            'title' => 'Pesanan Masuk - Admin Panel',
            'orders' => $orders
        ]);
    }

    public function ordersDelete(): void
    {
        $this->checkAuth('admin');

        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $this->orderModel->delete($id);
        }

        $this->redirect('/admin');
    }

    public function menu(): void
    {
        $this->checkAuth('admin');

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

        $this->view('admin/menu', [
            'title' => 'Kelola Menu - Admin Panel',
            'productsByCategory' => $categories
        ]);
    }

    public function addPage(): void
    {
        $this->checkAuth('admin');
        $this->view('admin/add', ['title' => 'Tambah Menu - Admin Panel']);
    }

    public function add(): void
    {
        $this->checkAuth('admin');

        $nama_menu  = trim($_POST['nama_menu'] ?? '');
        $harga_menu = (int)($_POST['harga_menu'] ?? 0);
        $kategori   = trim($_POST['kategori'] ?? '');
        $deskripsi  = trim($_POST['deskripsi'] ?? '');
        $gambar     = $_FILES['gambar'] ?? null;

        if ($nama_menu === '' || $harga_menu <= 0 || $kategori === '' || $deskripsi === '' || !$gambar || $gambar['error'] !== UPLOAD_ERR_OK) {
            $this->view('admin/add', [
                'title' => 'Tambah Menu - Admin Panel',
                'error' => 'Semua kolom wajib diisi dengan benar, termasuk cerita deskripsi menu!'
            ]);
            return;
        }

        // Secure file upload handling
        $targetDir = __DIR__ . '/../../assets/upload/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
            chmod($targetDir, 0777);
        }

        $fileName = basename($gambar['name']);
        // Sanitize filename to prevent directory traversal
        $fileName = preg_replace("/[^A-Za-z0-9\._-]/", "", $fileName);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($gambar['tmp_name'], $targetFilePath)) {
            $success = $this->productModel->create([
                'nama_menu'  => $nama_menu,
                'harga_menu' => $harga_menu,
                'kategori'   => $kategori,
                'deskripsi'  => $deskripsi,
                'gambar'     => $fileName
            ]);

            if ($success) {
                $this->redirect('/admin/menu');
            } else {
                $this->view('admin/add', [
                    'title' => 'Tambah Menu - Admin Panel',
                    'error' => 'Gagal menyimpan menu ke database!'
                ]);
            }
        } else {
            $this->view('admin/add', [
                'title' => 'Tambah Menu - Admin Panel',
                'error' => 'Gagal mengunggah gambar menu!'
            ]);
        }
    }

    public function editPage(): void
    {
        $this->checkAuth('admin');

        $id = (int)($_GET['id'] ?? 0);
        $product = $this->productModel->getById($id);

        if (!$product) {
            $this->redirect('/admin/menu');
        }

        $this->view('admin/edit', [
            'title' => 'Edit Menu - Admin Panel',
            'product' => $product
        ]);
    }

    public function edit(): void
    {
        $this->checkAuth('admin');

        $id_menu    = (int)($_POST['id_menu'] ?? 0);
        $nama_menu  = trim($_POST['nama_menu'] ?? '');
        $harga_menu = (int)($_POST['harga_menu'] ?? 0);
        $kategori   = trim($_POST['kategori'] ?? '');
        $deskripsi  = trim($_POST['deskripsi'] ?? '');
        $gambar     = $_FILES['gambar'] ?? null;

        $product = $this->productModel->getById($id_menu);
        if (!$product) {
            $this->redirect('/admin/menu');
        }

        if ($nama_menu === '' || $harga_menu <= 0 || $kategori === '' || $deskripsi === '') {
            $this->view('admin/edit', [
                'title' => 'Edit Menu - Admin Panel',
                'product' => $product,
                'error' => 'Semua kolom wajib diisi dengan benar, termasuk deskripsi!'
            ]);
            return;
        }

        $uploadedFileName = '';
        if ($gambar && $gambar['error'] === UPLOAD_ERR_OK) {
            // New image uploaded
            $targetDir = __DIR__ . '/../../assets/upload/';
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
                chmod($targetDir, 0777);
            }

            $fileName = basename($gambar['name']);
            $fileName = preg_replace("/[^A-Za-z0-9\._-]/", "", $fileName);
            $targetFilePath = $targetDir . $fileName;

            if (move_uploaded_file($gambar['tmp_name'], $targetFilePath)) {
                $uploadedFileName = $fileName;
            } else {
                $this->view('admin/edit', [
                    'title' => 'Edit Menu - Admin Panel',
                    'product' => $product,
                    'error' => 'Gagal mengunggah gambar baru!'
                ]);
                return;
            }
        }

        $success = $this->productModel->update($id_menu, [
            'nama_menu'  => $nama_menu,
            'harga_menu' => $harga_menu,
            'kategori'   => $kategori,
            'deskripsi'  => $deskripsi,
            'gambar'     => $uploadedFileName
        ]);

        if ($success) {
            $this->redirect('/admin/menu');
        } else {
            $this->view('admin/edit', [
                'title' => 'Edit Menu - Admin Panel',
                'product' => $product,
                'error' => 'Gagal memperbarui menu!'
            ]);
        }
    }

    public function delete(): void
    {
        $this->checkAuth('admin');

        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $this->productModel->delete($id);
        }

        $this->redirect('/admin/menu');
    }
}
