<?php
/**
 * Class UmpanBalik Model
 * Mengelola data umpan balik / feedback aspirasi
 */

require_once __DIR__ . '/Model.php';

class UmpanBalik extends Model {
    protected $table = 'umpan_balik';
    protected $primaryKey = 'id_feedback';
    
    /**
     * Tambah feedback baru
     */
    public function create($idAspirasi, $usernameAdmin, $isiFeedback) {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (id_aspirasi, username_admin, isi_feedback) VALUES (?, ?, ?)");
        return $stmt->execute([$idAspirasi, $usernameAdmin, $isiFeedback]);
    }
    
    /**
     * Get semua feedback untuk aspirasi tertentu
     */
    public function getByAspirasi($idAspirasi) {
        $sql = "SELECT ub.*, a.nama_admin 
                FROM {$this->table} ub 
                JOIN admin a ON ub.username_admin = a.username 
                WHERE ub.id_aspirasi = ? 
                ORDER BY ub.tgl_feedback ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idAspirasi]);
        return $stmt->fetchAll();
    }
    
    /**
     * Hitung feedback per aspirasi
     */
    public function countByAspirasi($idAspirasi) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM {$this->table} WHERE id_aspirasi = ?");
        $stmt->execute([$idAspirasi]);
        $result = $stmt->fetch();
        return $result['total'];
    }
}
