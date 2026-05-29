<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    public function index(): void
    {
        $this->checkGuest();
        $this->view('guest/home', ['title' => 'Five Star Restaurant - Home']);
    }

    public function menu(): void
    {
        $this->checkGuest();

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

        $this->view('guest/menu', [
            'title' => 'Daftar Menu - Five Star Restaurant',
            'productsByCategory' => $categories
        ]);
    }
}
