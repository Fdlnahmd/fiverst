<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class User
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM cust WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    public function authenticate(string $email, string $password): ?array
    {
        // For compatibility with default fiverst.sql seeds, we check against plain text passwords.
        $stmt = $this->db->prepare("SELECT * FROM cust WHERE email = :email AND pass = :password");
        $stmt->execute([
            'email'    => $email,
            'password' => $password
        ]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    public function create(array $data): bool
    {
        // Restrict 'stats' (role) strictly to 'user' for safety and security.
        $stmt = $this->db->prepare("INSERT INTO cust (email, pass, nama_lengkap, alamat, hp, stats) 
                                    VALUES (:email, :pass, :nama_lengkap, :alamat, :hp, 'user')");
        
        return $stmt->execute([
            'email'        => $data['email'],
            'pass'         => $data['password'],
            'nama_lengkap' => $data['nama_lengkap'],
            'alamat'       => $data['alamat'],
            'hp'           => $data['hp']
        ]);
    }
}
