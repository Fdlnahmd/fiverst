<?php

namespace App\Core;

class Controller
{
    protected function view(string $viewPath, array $data = [], bool $useLayout = true): void
    {
        extract($data);

        if ($useLayout) {
            // Automatically inject shared layouts (navbar, header, footer)
            require_once __DIR__ . '/../Views/layouts/header.php';
            require_once __DIR__ . '/../Views/' . $viewPath . '.php';
            require_once __DIR__ . '/../Views/layouts/footer.php';
        } else {
            require_once __DIR__ . '/../Views/' . $viewPath . '.php';
        }
    }

    protected function redirect(string $url): void
    {
        header("Location: " . $url);
        exit;
    }

    protected function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    protected function checkAuth(?string $requiredRole = null): void
    {
        $this->startSession();

        if (!isset($_SESSION['login_user']) || !isset($_SESSION['user_role'])) {
            $this->redirect('/login');
        }

        if ($requiredRole !== null && $_SESSION['user_role'] !== $requiredRole) {
            // Redirect based on role or to 404/Home
            if ($_SESSION['user_role'] === 'admin') {
                $this->redirect('/admin');
            } else {
                $this->redirect('/user');
            }
        }
    }

    protected function checkGuest(): void
    {
        $this->startSession();
        if (isset($_SESSION['login_user'])) {
            if ($_SESSION['user_role'] === 'admin') {
                $this->redirect('/admin');
            } else {
                $this->redirect('/user');
            }
        }
    }
}
