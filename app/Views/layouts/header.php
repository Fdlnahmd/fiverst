<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Five Star Restaurant - Nikmati kelezatan ayam kampung Hainan khas kami yang segar dengan bumbu warisan turun-temurun dan rasa autentik bintang lima.">
    <title><?= $title ?? 'Five Star Hainanese Chicken Rice' ?></title>
    
    <!-- Preconnect Origins -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin />
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    <!-- Preloading LCP background image for Homepages -->
    <?php
    $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $isHome = ($requestPath === '/' || $requestPath === '/home' || $requestPath === '/user');
    if ($isHome):
    ?>
    <link rel="preload" href="/assets/photo/section_chicken.webp?v=2" as="image" type="image/webp" fetchpriority="high">
    <?php endif; ?>

    <!-- Google Fonts (Loaded directly via link tags to prevent request chaining) -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Premium Favicons -->
    <link rel="icon" type="image/png" href="/assets/photo/favicon.png" />
    <link rel="shortcut icon" type="image/png" href="/favicon.png" />
    
    <!-- Bootstrap 5 CSS -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
    
    <!-- FontAwesome 6 Icons (Asynchronous Loading) -->
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'" crossorigin="anonymous" />
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" /></noscript>
    
    <!-- Theme Engine Script (Inlined to eliminate a render-blocking request and prevent layout flashes) -->
    <script>
        (function () {
            const savedTheme = localStorage.getItem('fiverst_theme') || 'dark';
            document.documentElement.setAttribute('data-theme', savedTheme);
            window.addEventListener('DOMContentLoaded', () => {
                const themeToggleBtn = document.getElementById('theme-toggle');
                updateToggleIcon(themeToggleBtn, savedTheme);
                if (themeToggleBtn) {
                    themeToggleBtn.addEventListener('click', () => {
                        const currentTheme = document.documentElement.getAttribute('data-theme');
                        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                        document.body.classList.add('theme-transition');
                        document.documentElement.setAttribute('data-theme', newTheme);
                        localStorage.setItem('fiverst_theme', newTheme);
                        updateToggleIcon(themeToggleBtn, newTheme);
                        setTimeout(() => {
                            document.body.classList.remove('theme-transition');
                        }, 400);
                    });
                }
            });
            function updateToggleIcon(btn, theme) {
                if (!btn) return;
                const icon = btn.querySelector('i');
                if (icon) {
                    if (theme === 'dark') {
                        icon.className = 'fa-solid fa-sun text-warning';
                    } else {
                        icon.className = 'fa-solid fa-moon text-primary';
                    }
                }
            }
        })();
    </script>
    
    <!-- SweetAlert2 JS (Deferred) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    
    <!-- Custom Style Sheet (Cached Version) -->
    <link rel="stylesheet" href="/assets/css/style.css?v=2.0.0">
</head>

<body>
<?php require_once __DIR__ . '/navbar.php'; ?>
<main>
