<?php

namespace App\Models;

use App\Config\Database;
use PDO;
use Exception;

class Order
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM pemesanan ORDER BY id_pemesanan DESC");
        return $stmt->fetchAll();
    }

    public function createOrder(array $cart, int $total): bool
    {
        try {
            $this->db->beginTransaction();

            $tanggal = date("Y-m-d");

            // 1. Insert into pemesanan
            $stmt = $this->db->prepare("INSERT INTO pemesanan (tanggal_pemesanan, total_belanja) VALUES (:tanggal, :total)");
            $stmt->execute([
                'tanggal' => $tanggal,
                'total'   => $total
            ]);

            $id_pemesanan = $this->db->lastInsertId();

            // 2. Insert each item into pemesanan_produk
            $stmtItem = $this->db->prepare("INSERT INTO pemesanan_produk (id_pemesanan, id_menu, jumlah) VALUES (:id_pemesanan, :id_menu, :jumlah)");
            foreach ($cart as $id_menu => $jumlah) {
                $stmtItem->execute([
                    'id_pemesanan' => $id_pemesanan,
                    'id_menu'      => $id_menu,
                    'jumlah'       => $jumlah
                ]);
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $this->db->beginTransaction();

            // Delete from pemesanan_produk first
            $stmtItem = $this->db->prepare("DELETE FROM pemesanan_produk WHERE id_pemesanan = :id");
            $stmtItem->execute(['id' => $id]);

            // Then delete from pemesanan
            $stmt = $this->db->prepare("DELETE FROM pemesanan WHERE id_pemesanan = :id");
            $stmt->execute(['id' => $id]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}
