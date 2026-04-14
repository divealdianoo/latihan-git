<?php
/**
 * Class Controller (Base Controller)
 * Parent class untuk semua controller
 */

require_once __DIR__ . '/../config/config.php';

abstract class Controller {
    
    /**
     * Merender view
     * @param string $view Path view (misal: 'auth/login')
     * @param array $data Data yang dikirim ke view
     */
    protected function view($view, $data = []) {
        extract($data);
        
        $viewPath = __DIR__ . '/../views/' . $view . '.php';
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("View {$view} tidak ditemukan");
        }
    }
    
    /**
     * Redirect ke URL tertentu
     * @param string $url
     */
    protected function redirect($url) {
        header("Location: " . BASE_URL . $url);
        exit;
    }
    
    /**
     * Set flash message
     * @param string $type (success, error, warning, info)
     * @param string $message
     */
    protected function setFlash($type, $message) {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }
    
    /**
     * Get flash message dan hapus dari session
     * @return array|null
     */
    protected function getFlash() {
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }
    
    /**
     * Cek apakah user sudah login
     * @param string $type ('siswa' atau 'admin')
     * @return bool
     */
    protected function isLoggedIn($type = 'siswa') {
        return isset($_SESSION[$type . '_logged_in']) && $_SESSION[$type . '_logged_in'] === true;
    }
    
    /**
     * Require login untuk akses
     * @param string $type
     */
    protected function requireLogin($type = 'siswa') {
        if (!$this->isLoggedIn($type)) {
            $this->setFlash('error', 'Silakan login terlebih dahulu');
            $this->redirect('?page=login');
        }
    }
}
