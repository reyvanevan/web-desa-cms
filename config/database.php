<?php
/**
 * Konfigurasi Database MySQL untuk CMS KKN Ciangsana
 * Menggunakan XAMPP localhost
 */

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // Default XAMPP kosong
define('DB_NAME', 'kkn_ciangsana');

// Koneksi menggunakan PDO
function getConnection() {
    static $conn = null;
    
    if ($conn === null) {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $conn = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            die("Koneksi database gagal: " . $e->getMessage());
        }
    }
    
    return $conn;
}

// Base URL untuk path
define('BASE_URL', '/kkn-ciangsana/');
define('UPLOAD_PATH', __DIR__ . '/../uploads/');
define('UPLOAD_URL', BASE_URL . 'uploads/');

// Max upload size (sebelum compress)
define('MAX_UPLOAD_SIZE', 10 * 1024 * 1024); // 10MB max upload
define('MAX_IMAGE_WIDTH', 1200); // Resize ke max 1200px width
define('IMAGE_QUALITY', 80); // Compress quality 80%
