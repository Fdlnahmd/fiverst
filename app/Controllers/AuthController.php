<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function loginPage(): void
    {
        $this->checkGuest();
        $this->view('auth/login', ['title' => 'Login - Five Star Restaurant'], true);
    }

    public function login(): void
    {
        $this->checkGuest();

        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($email === '' || $password === '') {
            $this->view('auth/login', [
                'title' => 'Login - Five Star Restaurant',
                'error' => 'Semua kolom wajib diisi!'
            ], true);
            return;
        }

        $user = $this->userModel->authenticate($email, $password);

        if ($user) {
            $this->startSession();
            $_SESSION['login_user'] = $user['nama_lengkap'];
            $_SESSION['login_user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['stats'];

            if ($user['stats'] === 'admin') {
                $this->redirect('/admin');
            } else {
                $this->redirect('/user');
            }
        } else {
            $this->view('auth/login', [
                'title' => 'Login - Five Star Restaurant',
                'error' => 'Email atau Password salah!'
            ], true);
        }
    }

    public function registerPage(): void
    {
        $this->checkGuest();
        $this->view('auth/register', ['title' => 'Daftar Akun - Five Star Restaurant'], true);
    }

    public function register(): void
    {
        $this->checkGuest();

        $data = [
            'email'        => trim($_POST['email'] ?? ''),
            'password'     => trim($_POST['password'] ?? ''),
            'nama_lengkap' => trim($_POST['nama_lengkap'] ?? ''),
            'alamat'       => trim($_POST['alamat'] ?? ''),
            'hp'           => trim($_POST['hp'] ?? '')
        ];

        // Basic Validation
        if (in_array('', $data, true)) {
            $this->view('auth/register', [
                'title' => 'Daftar Akun - Five Star Restaurant',
                'error' => 'Semua kolom wajib diisi!'
            ], true);
            return;
        }

        // Validate Email format
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->view('auth/register', [
                'title' => 'Daftar Akun - Five Star Restaurant',
                'error' => 'Format email tidak valid!'
            ], true);
            return;
        }

        if (strlen($data['password']) > 8) {
            $this->view('auth/register', [
                'title' => 'Daftar Akun - Five Star Restaurant',
                'error' => 'Password tidak boleh lebih dari 8 karakter!'
            ], true);
            return;
        }

        // Check if email already exists
        $existingUser = $this->userModel->findByEmail($data['email']);
        if ($existingUser) {
            $this->view('auth/register', [
                'title' => 'Daftar Akun - Five Star Restaurant',
                'error' => 'Email sudah terdaftar! Gunakan email lain.'
            ], true);
            return;
        }

        // Create standard 'user'
        $success = $this->userModel->create($data);
        if ($success) {
            $this->redirect('/login');
        } else {
            $this->view('auth/register', [
                'title' => 'Daftar Akun - Five Star Restaurant',
                'error' => 'Registrasi gagal! Silakan coba lagi.'
            ], true);
        }
    }

    public function logout(): void
    {
        $this->startSession();
        $_SESSION = [];
        session_destroy();
        $this->redirect('/login');
    }
}
