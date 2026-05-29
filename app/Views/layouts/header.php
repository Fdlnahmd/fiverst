<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Five Star Hainanese Chicken Rice' ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
    
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
    <!-- Theme Engine Script (Must execute before body rendering to prevent layout flashes) -->
    <script src="/assets/js/theme.js?v=<?= time(); ?>"></script>
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Custom Style Sheet -->
    <link rel="stylesheet" href="/assets/css/style.css?v=<?= time(); ?>">
</head>

<body>
<?php require_once __DIR__ . '/navbar.php'; ?>
