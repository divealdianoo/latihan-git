<?php
/**
 * Class Aspirasi Model
 * Mengelola data aspirasi siswa
 */

require_once __DIR__ . '/Model.php';

class Aspirasi extends Model {
    protected $table = 'aspirasi';
    protected $primaryKey = 'id_aspirasi';
    
    /**
     * Tambah aspirasi baru
     */
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (nis, id_kategori, judul, isi_aspirasi, lokasi) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['nis'],
            $data['id_kategori'],
            $data['judul'],
            $data['isi_aspirasi'],
            $data['lokasi']
        ]);
    }
    
    /**
     * Get semua aspirasi dengan join siswa dan kategori
     */
    public function getAllWithDetail() {
        $sql = "SELECT a.*, s.nama_siswa, s.kelas, k.nama_kategori 
                FROM {$this->table} a 
                JOIN siswa s ON a.nis = s.nis 
                JOIN kategori k ON a.id_kategori = k.id_kategori 
                ORDER BY a.tgl_lapor DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    /**
     * Get aspirasi detail by ID dengan join
     */
    public function getDetailById($id) {
        $sql = "SELECT a.*, s.nama_siswa, s.kelas, k.nama_kategori 
                FROM {$this->table} a 
                JOIN siswa s ON a.nis = s.nis 
                JOIN kategori k ON a.id_kategori = k.id_kategori 
                WHERE a.id_aspirasi = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Get aspirasi by NIS siswa
     */
    public function getByNis($nis) {
        $sql = "SELECT a.*, k.nama_kategori 
                FROM {$this->table} a 
                JOIN kategori k ON a.id_kategori = k.id_kategori 
                WHERE a.nis = ? 
                ORDER BY a.tgl_lapor DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$nis]);
        return $stmt->fetchAll();
    }
    
    /**
     * Filter aspirasi per tanggal
     */
    public function getByTanggal($tanggal) {
        $sql = "SELECT a.*, s.nama_siswa, s.kelas, k.nama_kategori 
                FROM {$this->table} a 
                JOIN siswa s ON a.nis = s.nis 
                JOIN kategori k ON a.id_kategori = k.id_kategori 
                WHERE DATE(a.tgl_lapor) = ? 
                ORDER BY a.tgl_lapor DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$tanggal]);
        return $stmt->fetchAll();
    }
    
    /**
     * Filter aspirasi per bulan
     */
    public function getByBulan($bulan, $tahun) {
        $sql = "SELECT a.*, s.nama_siswa, s.kelas, k.nama_kategori 
                FROM {$this->table} a 
                JOIN siswa s ON a.nis = s.nis 
                JOIN kategori k ON a.id_kategori = k.id_kategori 
                WHERE MONTH(a.tgl_lapor) = ? AND YEAR(a.tgl_lapor) = ? 
                ORDER BY a.tgl_lapor DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$bulan, $tahun]);
        return $stmt->fetchAll();
    }
    
    /**
     * Filter aspirasi per siswa (NIS)
     */
    public function getBySiswa($nis) {
        $sql = "SELECT a.*, s.nama_siswa, s.kelas, k.nama_kategori 
                FROM {$this->table} a 
                JOIN siswa s ON a.nis = s.nis 
                JOIN kategori k ON a.id_kategori = k.id_kategori 
                WHERE a.nis = ? 
                ORDER BY a.tgl_lapor DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$nis]);
        return $stmt->fetchAll();
    }
    
    /**
     * Filter aspirasi per kategori
     */
    public function getByKategori($idKategori) {
        $sql = "SELECT a.*, s.nama_siswa, s.kelas, k.nama_kategori 
                FROM {$this->table} a 
                JOIN siswa s ON a.nis = s.nis 
                JOIN kategori k ON a.id_kategori = k.id_kategori 
                WHERE a.id_kategori = ? 
                ORDER BY a.tgl_lapor DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idKategori]);
        return $stmt->fetchAll();
    }
    
    /**
     * Filter aspirasi per status
     */
    public function getByStatus($status) {
        $sql = "SELECT a.*, s.nama_siswa, s.kelas, k.nama_kategori 
                FROM {$this->table} a 
                JOIN siswa s ON a.nis = s.nis 
                JOIN kategori k ON a.id_kategori = k.id_kategori 
                WHERE a.status = ? 
                ORDER BY a.tgl_lapor DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$status]);
        return $stmt->fetchAll();
    }
    
    /**
     * Update status aspirasi
     */
    public function updateStatus($id, $status, $prioritas, $progres, $catatanProgres, $usernameAdmin) {
        $sql = "UPDATE {$this->table} SET status = ?, prioritas = ?, progres = ?, catatan_progres = ?, tgl_update = NOW(), username_admin = ? WHERE id_aspirasi = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$status, $prioritas, $progres, $catatanProgres, $usernameAdmin, $id]);
    }
    
    /**
     * Hitung aspirasi berdasarkan status
     */
    public function countByStatus($status) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM {$this->table} WHERE status = ?");
        $stmt->execute([$status]);
        $result = $stmt->fetch();
        return $result['total'];
    }
    
    /**
     * Get history aspirasi (yang sudah selesai atau ditolak)
     */
    public function getHistory() {
        $sql = "SELECT a.*, s.nama_siswa, s.kelas, k.nama_kategori 
                FROM {$this->table} a 
                JOIN siswa s ON a.nis = s.nis 
                JOIN kategori k ON a.id_kategori = k.id_kategori 
                WHERE a.status IN ('Selesai', 'Ditolak') 
                ORDER BY a.tgl_update DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    /**
     * Get history aspirasi by NIS
     */
    public function getHistoryByNis($nis) {
        $sql = "SELECT a.*, k.nama_kategori 
                FROM {$this->table} a 
                JOIN kategori k ON a.id_kategori = k.id_kategori 
                WHERE a.nis = ? 
                ORDER BY a.tgl_lapor DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$nis]);
        return $stmt->fetchAll();
    }
    
    /**
     * Search aspirasi
     */
    public function search($keyword) {
        $sql = "SELECT a.*, s.nama_siswa, s.kelas, k.nama_kategori 
                FROM {$this->table} a 
                JOIN siswa s ON a.nis = s.nis 
                JOIN kategori k ON a.id_kategori = k.id_kategori 
                WHERE a.judul LIKE ? OR a.isi_aspirasi LIKE ? OR s.nama_siswa LIKE ?
                ORDER BY a.tgl_lapor DESC";
        $stmt = $this->db->prepare($sql);
        $like = "%{$keyword}%";
        $stmt->execute([$like, $like, $like]);
        return $stmt->fetchAll();
    }
}
