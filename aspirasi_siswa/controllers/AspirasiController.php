<?php
/**
 * Class AspirasiController
 * Mengelola aspirasi dari sisi siswa
 */

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Aspirasi.php';
require_once __DIR__ . '/../models/Kategori.php';
require_once __DIR__ . '/../models/UmpanBalik.php';

class AspirasiController extends Controller {
    private $aspirasiModel;
    private $kategoriModel;
    private $umpanBalikModel;
    
    public function __construct() {
        $this->aspirasiModel = new Aspirasi();
        $this->kategoriModel = new Kategori();
        $this->umpanBalikModel = new UmpanBalik();
    }
    
    /**
     * Halaman daftar aspirasi siswa
     */
    public function index() {
        $this->requireLogin('siswa');
        
        $nis = $_SESSION['siswa_nis'];
        $aspirasi = $this->aspirasiModel->getByNis($nis);
        $flash = $this->getFlash();
        
        $this->view('siswa/aspirasi', [
            'aspirasi' => $aspirasi,
            'flash' => $flash
        ]);
    }
    
    /**
     * Halaman buat aspirasi baru
     */
    public function create() {
        $this->requireLogin('siswa');
        
        $kategori = $this->kategoriModel->getAll();
        $flash = $this->getFlash();
        
        $this->view('siswa/aspirasi_create', [
            'kategori' => $kategori,
            'flash' => $flash
        ]);
    }
    
    /**
     * Simpan aspirasi baru
     */
    public function store() {
        $this->requireLogin('siswa');
        
        $data = [
            'nis' => $_SESSION['siswa_nis'],
            'id_kategori' => $_POST['id_kategori'] ?? '',
            'judul' => $_POST['judul'] ?? '',
            'isi_aspirasi' => $_POST['isi_aspirasi'] ?? '',
            'lokasi' => $_POST['lokasi'] ?? ''
        ];
        
        if (empty($data['judul']) || empty($data['isi_aspirasi']) || empty($data['id_kategori'])) {
            $this->setFlash('error', 'Judul, kategori, dan isi aspirasi wajib diisi');
            $this->redirect('?page=aspirasi-create');
        }
        
        if ($this->aspirasiModel->create($data)) {
            $this->setFlash('success', 'Aspirasi berhasil dikirim!');
            $this->redirect('?page=aspirasi');
        } else {
            $this->setFlash('error', 'Gagal mengirim aspirasi');
            $this->redirect('?page=aspirasi-create');
        }
    }
    
    /**
     * Detail aspirasi siswa
     */
    public function show($id) {
        $this->requireLogin('siswa');
        
        $aspirasi = $this->aspirasiModel->getDetailById($id);
        
        if (!$aspirasi || $aspirasi['nis'] != $_SESSION['siswa_nis']) {
            $this->setFlash('error', 'Aspirasi tidak ditemukan');
            $this->redirect('?page=aspirasi');
        }
        
        $feedbacks = $this->umpanBalikModel->getByAspirasi($id);
        $flash = $this->getFlash();
        
        $this->view('siswa/aspirasi_detail', [
            'aspirasi' => $aspirasi,
            'feedbacks' => $feedbacks,
            'flash' => $flash
        ]);
    }
    
    /**
     * Halaman histori aspirasi siswa
     */
    public function history() {
        $this->requireLogin('siswa');
        
        $nis = $_SESSION['siswa_nis'];
        $aspirasi = $this->aspirasiModel->getHistoryByNis($nis);
        $flash = $this->getFlash();
        
        $this->view('siswa/history', [
            'aspirasi' => $aspirasi,
            'flash' => $flash
        ]);
    }
}
