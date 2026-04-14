<?php
/**
 * Class KategoriController
 * Mengelola kategori aspirasi (admin only)
 */

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Kategori.php';

class KategoriController extends Controller {
    private $kategoriModel;
    
    public function __construct() {
        $this->kategoriModel = new Kategori();
    }
    
    /**
     * Halaman daftar kategori
     */
    public function index() {
        $this->requireLogin('admin');
        
        $kategori = $this->kategoriModel->getAll();
        $flash = $this->getFlash();
        
        $this->view('admin/kategori', [
            'kategori' => $kategori,
            'flash' => $flash
        ]);
    }
    
    /**
     * Simpan kategori baru
     */
    public function store() {
        $this->requireLogin('admin');
        
        $nama = $_POST['nama_kategori'] ?? '';
        
        if (empty($nama)) {
            $this->setFlash('error', 'Nama kategori tidak boleh kosong');
            $this->redirect('?page=kategori');
        }
        
        if ($this->kategoriModel->create($nama)) {
            $this->setFlash('success', 'Kategori berhasil ditambahkan');
        } else {
            $this->setFlash('error', 'Gagal menambahkan kategori');
        }
        
        $this->redirect('?page=kategori');
    }
    
    /**
     * Update kategori
     */
    public function update() {
        $this->requireLogin('admin');
        
        $id = $_POST['id_kategori'] ?? '';
        $nama = $_POST['nama_kategori'] ?? '';
        
        if (empty($id) || empty($nama)) {
            $this->setFlash('error', 'Data tidak valid');
            $this->redirect('?page=kategori');
        }
        
        if ($this->kategoriModel->update($id, $nama)) {
            $this->setFlash('success', 'Kategori berhasil diperbarui');
        } else {
            $this->setFlash('error', 'Gagal memperbarui kategori');
        }
        
        $this->redirect('?page=kategori');
    }
    
    /**
     * Delete kategori
     */
    public function delete() {
        $this->requireLogin('admin');
        
        $id = $_POST['id_kategori'] ?? '';
        
        if (empty($id)) {
            $this->setFlash('error', 'Data tidak valid');
            $this->redirect('?page=kategori');
        }
        
        if ($this->kategoriModel->delete($id)) {
            $this->setFlash('success', 'Kategori berhasil dihapus');
        } else {
            $this->setFlash('error', 'Gagal menghapus kategori. Pastikan tidak ada aspirasi yang menggunakan kategori ini.');
        }
        
        $this->redirect('?page=kategori');
    }
}
