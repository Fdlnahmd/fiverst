<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class Product
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM produk ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function getByCategory(string $category): array
    {
        $stmt = $this->db->prepare("SELECT * FROM produk WHERE kategori = :kategori");
        $stmt->execute(['kategori' => $category]);
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM produk WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch();

        return $product ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("INSERT INTO produk (nama_menu, harga_menu, gambar, kategori, deskripsi) 
                                    VALUES (:nama_menu, :harga_menu, :gambar, :kategori, :deskripsi)");
        
        return $stmt->execute([
            'nama_menu'  => $data['nama_menu'],
            'harga_menu' => $data['harga_menu'],
            'gambar'     => $data['gambar'],
            'kategori'   => $data['kategori'],
            'deskripsi'  => $data['deskripsi']
        ]);
    }

    public function update(int $id, array $data): bool
    {
        if (isset($data['gambar']) && $data['gambar'] !== '') {
            $stmt = $this->db->prepare("UPDATE produk SET nama_menu = :nama_menu, harga_menu = :harga_menu, gambar = :gambar, kategori = :kategori, deskripsi = :deskripsi WHERE id = :id");
            return $stmt->execute([
                'id'         => $id,
                'nama_menu'  => $data['nama_menu'],
                'harga_menu' => $data['harga_menu'],
                'gambar'     => $data['gambar'],
                'kategori'   => $data['kategori'],
                'deskripsi'  => $data['deskripsi']
            ]);
        } else {
            $stmt = $this->db->prepare("UPDATE produk SET nama_menu = :nama_menu, harga_menu = :harga_menu, kategori = :kategori, deskripsi = :deskripsi WHERE id = :id");
            return $stmt->execute([
                'id'         => $id,
                'nama_menu'  => $data['nama_menu'],
                'harga_menu' => $data['harga_menu'],
                'kategori'   => $data['kategori'],
                'deskripsi'  => $data['deskripsi']
            ]);
        }
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM produk WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
