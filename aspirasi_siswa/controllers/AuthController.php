<?php
/**
 * Class AuthController
 * Mengelola autentikasi siswa dan admin
 */

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Siswa.php';
require_once __DIR__ . '/../models/Admin.php';

class AuthController extends Controller {
    private $siswaModel;
    private $adminModel;
    
    public function __construct() {
        $this->siswaModel = new Siswa();
        $this->adminModel = new Admin();
    }
    
    /**
     * Tampilkan halaman login (unified)
     */
    public function login() {
        if ($this->isLoggedIn('siswa')) {
            $this->redirect('?page=aspirasi');
        }
        if ($this->isLoggedIn('admin')) {
            $this->redirect('?page=dashboard');
        }
        
        $flash = $this->getFlash();
        $this->view('auth/login', ['flash' => $flash]);
    }
    
    /**
     * Proses login terpadu (Siswa / Admin)
     */
    public function doLogin() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (empty($username) || empty($password)) {
            $this->setFlash('error', 'Username dan password harus diisi');
            $this->redirect('?page=login');
        }
        
        // Coba login sebagai admin dulu
        $admin = $this->adminModel->login($username, $password);
        if ($admin) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_nama'] = $admin['nama_admin'];
            
            $this->setFlash('success', 'Selamat datang, ' . $admin['nama_admin'] . '!');
            $this->redirect('?page=dashboard');
        }
        
        // Kalau bukan admin, coba login sebagai siswa
        $siswa = $this->siswaModel->login($username, $password);
        if ($siswa) {
            $_SESSION['siswa_logged_in'] = true;
            $_SESSION['siswa_nis'] = $siswa['nis'];
            $_SESSION['siswa_nama'] = $siswa['nama_siswa'];
            $_SESSION['siswa_kelas'] = $siswa['kelas'];
            $_SESSION['siswa_username'] = $siswa['username'];
            
            $this->setFlash('success', 'Selamat datang, ' . $siswa['nama_siswa'] . '!');
            $this->redirect('?page=aspirasi');
        }
        
        // Kalau dua-duanya gagal
        $this->setFlash('error', 'Username atau password salah');
        $this->redirect('?page=login');
    }
    
    /**
     * Logout siswa
     */
    public function logoutSiswa() {
        unset($_SESSION['siswa_logged_in']);
        unset($_SESSION['siswa_nis']);
        unset($_SESSION['siswa_nama']);
        unset($_SESSION['siswa_kelas']);
        unset($_SESSION['siswa_username']);
        
        $this->setFlash('success', 'Berhasil logout');
        $this->redirect('?page=login');
    }
    
    /**
     * Logout admin
     */
    public function logoutAdmin() {
        unset($_SESSION['admin_logged_in']);
        unset($_SESSION['admin_username']);
        unset($_SESSION['admin_nama']);
        
        $this->setFlash('success', 'Berhasil logout');
        $this->redirect('?page=login');
    }
}
