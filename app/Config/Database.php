<?php

namespace App\Config;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    private function __construct() {}

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $host = getenv('DB_HOST') ?: 'db';
            $port = getenv('DB_PORT') ?: '3306';
            $db   = getenv('DB_NAME') ?: 'fiverst';
            $user = getenv('DB_USER') ?: 'root';
            $pass = getenv('DB_PASS') ?: 'rootpassword';
            $charset = 'utf8mb4';

            $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$instance = new PDO($dsn, $user, $pass, $options);
                
                // Automatic Database Migration (Self-Healing)
                try {
                    $check = self::$instance->query("SHOW COLUMNS FROM cust LIKE 'username'");
                    if ($check && $check->rowCount() > 0) {
                        self::$instance->exec("ALTER TABLE cust CHANGE COLUMN username email VARCHAR(255) NOT NULL");
                        self::$instance->exec("ALTER TABLE cust MODIFY COLUMN jenis_kelamin VARCHAR(50) NULL");
                    }
                    
                    // Always proactively migrate pre-existing legacy username records to valid email addresses
                    self::$instance->exec("UPDATE cust SET email = 'vina@gmail.com' WHERE email = 'vina'");
                    self::$instance->exec("UPDATE cust SET email = 'fadlan@gmail.com' WHERE email = 'fadlan'");
                    
                    // Renaming 'vina' admin account to 'admin' (email, pass, nama_lengkap)
                    self::$instance->exec("UPDATE cust SET email = 'admin@gmail.com', pass = 'admin123', nama_lengkap = 'Admin' WHERE email = 'vina@gmail.com'");
                    
                    // Self-healing migration for 'produk' table schema to add 'kategori' and 'deskripsi'
                    $checkKategori = self::$instance->query("SHOW COLUMNS FROM produk LIKE 'kategori'");
                    if ($checkKategori && $checkKategori->rowCount() === 0) {
                        self::$instance->exec("ALTER TABLE produk ADD COLUMN kategori VARCHAR(50) NOT NULL DEFAULT 'CHICKEN'");
                        
                        // Seed categories to match fiverst structure
                        $categoriesSeed = [
                            1 => 'CHICKEN', 4 => 'PORK', 5 => 'PORK', 6 => 'TOFU & OMELETTE',
                            8 => 'TOFU & OMELETTE', 9 => 'FISH', 10 => 'FISH', 11 => 'SEAFOOD',
                            12 => 'SEAFOOD', 13 => 'SEAFOOD', 14 => 'DESSERTS & BEVERAGES',
                            15 => 'DESSERTS & BEVERAGES', 16 => 'DESSERTS & BEVERAGES', 18 => 'VEGETABLES'
                        ];
                        foreach ($categoriesSeed as $id => $cat) {
                            $stmt = self::$instance->prepare("UPDATE produk SET kategori = ? WHERE id = ?");
                            $stmt->execute([$cat, $id]);
                        }
                    }

                    $checkDesk = self::$instance->query("SHOW COLUMNS FROM produk LIKE 'deskripsi'");
                    if ($checkDesk && $checkDesk->rowCount() === 0) {
                        self::$instance->exec("ALTER TABLE produk ADD COLUMN deskripsi TEXT NULL");
                        
                        // Seed premium Chinese fine-dining culinary descriptions
                        $descriptions = [
                            1 => 'Udang segar renyah dibalut dengan pasta terasi khas aromatik yang lezat dan gurih.',
                            4 => 'Iga babi pilihan dimasak dengan saus kekaisaran madu manis gurih tradisional yang legit.',
                            5 => 'Iga babi empuk berbalut saus telur asin (salted egg) creamy yang gurih dan harum daun kari.',
                            6 => 'Tahu sutera lembut digoreng keemasan disajikan dengan saus asam manis khas Thailand.',
                            8 => 'Tahu tradisional Five Star dimasak ala rumahan dengan jamur dan sayuran segar berkuah kental.',
                            9 => 'Ikan pari segar panggang bumbu BBQ pedas harum dibakar di atas daun pisang aromatik.',
                            10 => 'Irisan fillet ikan gurame segar berbalut saus asam manis nanas oriental klasik.',
                            11 => 'Kepiting cangkang lunak khas disiram saus cabai Singapura kental pedas manis berempah.',
                            12 => 'Udang windu jumbo digoreng garing berselimut remahan sereal gandum manis renyah daun kari.',
                            13 => 'Cumi segar empuk berbalut tepung telur asin gurih melimpah dan harum rempah.',
                            14 => 'Puding mangga harum manis legendaris disajikan dingin dengan mutiara sago dan susu krim.',
                            15 => 'Es serut kacang merah legendaris bertabur gula merah Melaka kental dan sirup wangi.',
                            16 => 'Sup manis kacang merah hangat berpadu biji teratai lembut berkhasiat untuk penutup hidangan.',
                            18 => 'Sayur Kailan muda segar ditumis bawang putih aromatik dengan saus tiram premium.'
                        ];
                        foreach ($descriptions as $id => $desc) {
                            $stmt = self::$instance->prepare("UPDATE produk SET deskripsi = ? WHERE id = ?");
                            $stmt->execute([$desc, $id]);
                        }
                    }
                } catch (\Exception $migrationEx) {
                    // Silently ignore if already migrated or database values are altered
                }
            } catch (PDOException $e) {
                // Return a clear error message in production, or raw error during development
                die("Koneksi database gagal: " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}
