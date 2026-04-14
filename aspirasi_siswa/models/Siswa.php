<?php
/**
 * Class Siswa Model
 * Mengelola data siswa
 */

require_once __DIR__ . '/Model.php';

class Siswa extends Model {
    protected $table = 'siswa';
    protected $primaryKey = 'nis';
    
    /**
     * Login siswa
     * @param string $username
     * @param string $password
     * @return array|false
     */
    public function login($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE username = ? AND password = ?");
        $stmt->execute([$username, $password]);
        return $stmt->fetch();
    }
    
    /**
     * Get siswa by NIS
     * @param int $nis
     * @return array|false
     */
    public function getByNis($nis) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE nis = ?");
        $stmt->execute([$nis]);
        return $stmt->fetch();
    }
}
