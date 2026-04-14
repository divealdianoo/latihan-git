<?php
/**
 * Class Admin Model
 * Mengelola data admin
 */

require_once __DIR__ . '/Model.php';

class Admin extends Model {
    protected $table = 'admin';
    protected $primaryKey = 'username';
    
    /**
     * Login admin
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
     * Get admin by username
     * @param string $username
     * @return array|false
     */
    public function getByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }
}
