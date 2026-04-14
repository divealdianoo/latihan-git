<?php
/**
 * Class Kategori Model
 * Mengelola data kategori aspirasi
 */

require_once __DIR__ . '/Model.php';

class Kategori extends Model {
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    
    /**
     * Tambah kategori baru
     * @param string $nama
     * @return bool
     */
    public function create($nama) {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (nama_kategori) VALUES (?)");
        return $stmt->execute([$nama]);
    }
    
    /**
     * Update kategori
     * @param int $id
     * @param string $nama
     * @return bool
     */
    public function update($id, $nama) {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET nama_kategori = ? WHERE id_kategori = ?");
        return $stmt->execute([$nama, $id]);
    }
}
