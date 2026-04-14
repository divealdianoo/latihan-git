<?php
/**
 * Entry Point - Router Aplikasi
 * Sistem Pengaduan Aspirasi Siswa
 */

// Load config
require_once __DIR__ . '/config/config.php';

// Load Controllers
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/AspirasiController.php';
require_once __DIR__ . '/controllers/AdminController.php';
require_once __DIR__ . '/controllers/KategoriController.php';

// Inisialisasi controller
$authController = new AuthController();
$aspirasiController = new AspirasiController();
$adminController = new AdminController();
$kategoriController = new KategoriController();

// Get page and action
$page = $_GET['page'] ?? 'login';
$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';

// Handle Actions (POST requests)
if ($action) {
    switch ($action) {
        // Auth Actions
        case 'login-action':
            $authController->doLogin();
            break;
        case 'logout-siswa':
            $authController->logoutSiswa();
            break;
        case 'logout-admin':
            $authController->logoutAdmin();
            break;
            
        // Aspirasi Actions (Siswa)
        case 'aspirasi-store':
            $aspirasiController->store();
            break;
            
        // Admin Actions
        case 'update-status':
            $adminController->updateStatus();
            break;
        case 'send-feedback':
            $adminController->sendFeedback();
            break;
            
        // Kategori Actions
        case 'kategori-store':
            $kategoriController->store();
            break;
        case 'kategori-update':
            $kategoriController->update();
            break;
        case 'kategori-delete':
            $kategoriController->delete();
            break;
            
        default:
            header("Location: " . BASE_URL);
            exit;
    }
}

// Handle Pages (GET requests)
switch ($page) {
    // Auth Pages
    case 'login':
        $authController->login();
        break;
        
    // Siswa Pages
    case 'aspirasi':
        $aspirasiController->index();
        break;
    case 'aspirasi-create':
        $aspirasiController->create();
        break;
    case 'aspirasi-detail':
        $aspirasiController->show($id);
        break;
    case 'aspirasi-history':
        $aspirasiController->history();
        break;
        
    // Admin Pages
    case 'dashboard':
        $adminController->dashboard();
        break;
    case 'aspirasi-admin':
        $adminController->aspirasi();
        break;
    case 'aspirasi-detail-admin':
        $adminController->showAspirasi($id);
        break;
    case 'kategori':
        $kategoriController->index();
        break;
    case 'history-admin':
        $adminController->history();
        break;
        
    default:
        header("Location: " . BASE_URL . "?page=login");
        exit;
}
