<?php
/**
 * Class AdminController
 * Mengelola fitur admin
 */

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Aspirasi.php';
require_once __DIR__ . '/../models/Kategori.php';
require_once __DIR__ . '/../models/UmpanBalik.php';
require_once __DIR__ . '/../models/Siswa.php';

class AdminController extends Controller {
    private $aspirasiModel;
    private $kategoriModel;
    private $umpanBalikModel;
    private $siswaModel;
    
    public function __construct() {
        $this->aspirasiModel = new Aspirasi();
        $this->kategoriModel = new Kategori();
        $this->umpanBalikModel = new UmpanBalik();
        $this->siswaModel = new Siswa();
    }
    
    /**
     * Dashboard admin
     */
    public function dashboard() {
        $this->requireLogin('admin');
        
        $totalAspirasi = $this->aspirasiModel->count();
        $menunggu = $this->aspirasiModel->countByStatus('Menunggu');
        $diproses = $this->aspirasiModel->countByStatus('Diproses');
        $selesai = $this->aspirasiModel->countByStatus('Selesai');
        $ditolak = $this->aspirasiModel->countByStatus('Ditolak');
        
        $recentAspirasi = $this->aspirasiModel->getAllWithDetail();
        $flash = $this->getFlash();
        
        $this->view('admin/dashboard', [
            'totalAspirasi' => $totalAspirasi,
            'menunggu' => $menunggu,
            'diproses' => $diproses,
            'selesai' => $selesai,
            'ditolak' => $ditolak,
            'recentAspirasi' => $recentAspirasi,
            'flash' => $flash
        ]);
    }
    
    /**
     * List semua aspirasi dengan filter
     */
    public function aspirasi() {
        $this->requireLogin('admin');
        
        $filter = $_GET['filter'] ?? '';
        $value = $_GET['value'] ?? '';
        $search = $_GET['search'] ?? '';
        
        $aspirasi = [];
        
        if (!empty($search)) {
            $aspirasi = $this->aspirasiModel->search($search);
        } elseif (!empty($filter) && !empty($value)) {
            switch ($filter) {
                case 'tanggal':
                    $aspirasi = $this->aspirasiModel->getByTanggal($value);
                    break;
                case 'bulan':
                    $parts = explode('-', $value);
                    if (count($parts) == 2) {
                        $aspirasi = $this->aspirasiModel->getByBulan($parts[1], $parts[0]);
                    }
                    break;
                case 'siswa':
                    $aspirasi = $this->aspirasiModel->getBySiswa($value);
                    break;
                case 'kategori':
                    $aspirasi = $this->aspirasiModel->getByKategori($value);
                    break;
                case 'status':
                    $aspirasi = $this->aspirasiModel->getByStatus($value);
                    break;
                default:
                    $aspirasi = $this->aspirasiModel->getAllWithDetail();
            }
        } else {
            $aspirasi = $this->aspirasiModel->getAllWithDetail();
        }
        
        $kategori = $this->kategoriModel->getAll();
        $siswaList = $this->siswaModel->getAll();
        $flash = $this->getFlash();
        
        $this->view('admin/aspirasi', [
            'aspirasi' => $aspirasi,
            'kategori' => $kategori,
            'siswaList' => $siswaList,
            'filter' => $filter,
            'value' => $value,
            'search' => $search,
            'flash' => $flash
        ]);
    }
    
    /**
     * Detail aspirasi + update status + feedback
     */
    public function showAspirasi($id) {
        $this->requireLogin('admin');
        
        $aspirasi = $this->aspirasiModel->getDetailById($id);
        
        if (!$aspirasi) {
            $this->setFlash('error', 'Aspirasi tidak ditemukan');
            $this->redirect('?page=aspirasi-admin');
        }
        
        $feedbacks = $this->umpanBalikModel->getByAspirasi($id);
        $flash = $this->getFlash();
        
        $this->view('admin/aspirasi_detail', [
            'aspirasi' => $aspirasi,
            'feedbacks' => $feedbacks,
            'flash' => $flash
        ]);
    }
    
    /**
     * Update status aspirasi
     */
    public function updateStatus() {
        $this->requireLogin('admin');
        
        $id = $_POST['id_aspirasi'] ?? '';
        $status = $_POST['status'] ?? '';
        $prioritas = $_POST['prioritas'] ?? 'Sedang';
        $progres = $_POST['progres'] ?? 0;
        $catatanProgres = $_POST['catatan_progres'] ?? '';
        $usernameAdmin = $_SESSION['admin_username'];
        
        if ($this->aspirasiModel->updateStatus($id, $status, $prioritas, $progres, $catatanProgres, $usernameAdmin)) {
            $this->setFlash('success', 'Status aspirasi berhasil diperbarui');
        } else {
            $this->setFlash('error', 'Gagal memperbarui status');
        }
        
        $this->redirect('?page=aspirasi-detail-admin&id=' . $id);
    }
    
    /**
     * Kirim umpan balik
     */
    public function sendFeedback() {
        $this->requireLogin('admin');
        
        $idAspirasi = $_POST['id_aspirasi'] ?? '';
        $isiFeedback = $_POST['isi_feedback'] ?? '';
        $usernameAdmin = $_SESSION['admin_username'];
        
        if (empty($isiFeedback)) {
            $this->setFlash('error', 'Isi feedback tidak boleh kosong');
            $this->redirect('?page=aspirasi-detail-admin&id=' . $idAspirasi);
        }
        
        if ($this->umpanBalikModel->create($idAspirasi, $usernameAdmin, $isiFeedback)) {
            $this->setFlash('success', 'Umpan balik berhasil dikirim');
        } else {
            $this->setFlash('error', 'Gagal mengirim umpan balik');
        }
        
        $this->redirect('?page=aspirasi-detail-admin&id=' . $idAspirasi);
    }
    
    /**
     * History aspirasi
     */
    public function history() {
        $this->requireLogin('admin');
        
        $aspirasi = $this->aspirasiModel->getHistory();
        $flash = $this->getFlash();
        
        $this->view('admin/history', [
            'aspirasi' => $aspirasi,
            'flash' => $flash
        ]);
    }
}
