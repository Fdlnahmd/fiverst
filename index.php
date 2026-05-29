<?php
/**
 * Fiverst - Premium Restaurant MVC Application
 * Front Controller Entry Point
 */

// 1. Start global session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Set timezone and error handling
date_default_timezone_set('Asia/Jakarta');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 3. Load App Bootstrapper
require_once __DIR__ . '/app/Core/App.php';

// 4. Run Application Routing
App\Core\App::run();
