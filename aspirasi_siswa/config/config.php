<?php
/**
 * Konfigurasi Aplikasi
 * Sistem Pengaduan Aspirasi Siswa
 */

// Konfigurasi Database
define('DB_HOST', 'localhost');
define('DB_NAME', 'db_aspirasi_siswa');
define('DB_USER', 'root');
define('DB_PASS', '');

// Konfigurasi Aplikasi - Auto-detect Base URL
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$domain = $_SERVER['HTTP_HOST'];
$dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$dir = $dir === '/' ? '' : $dir;
define('BASE_URL', $protocol . "://" . $domain . $dir . "/");

define('APP_NAME', 'Sistem Aspirasi Siswa');

// Timezone
date_default_timezone_set('Asia/Jakarta');

// Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
