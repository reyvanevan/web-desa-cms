<?php
/**
 * Helper Functions untuk CMS KKN Ciangsana
 */

require_once __DIR__ . '/../config/database.php';

/**
 * Ambil setting dari database
 */
function get_setting($key, $default = '') {
    try {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT setting_value FROM settings WHERE setting_key = ?");
        $stmt->execute([$key]);
        $result = $stmt->fetch();
        return $result ? $result['setting_value'] : $default;
    } catch (PDOException $e) {
        return $default;
    }
}

/**
 * Update atau insert setting
 */
function set_setting($key, $value, $type = 'text') {
    try {
        $conn = getConnection();
        $stmt = $conn->prepare("INSERT INTO settings (setting_key, setting_value, setting_type) 
                                VALUES (?, ?, ?) 
                                ON DUPLICATE KEY UPDATE setting_value = ?, updated_at = CURRENT_TIMESTAMP");
        $stmt->execute([$key, $value, $type, $value]);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

/**
 * Ambil semua misi
 */
function get_misi($active_only = true) {
    try {
        $conn = getConnection();
        $sql = "SELECT * FROM misi";
        if ($active_only) {
            $sql .= " WHERE is_active = 1";
        }
        $sql .= " ORDER BY sort_order ASC";
        $stmt = $conn->query($sql);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * Ambil semua program aktif
 */
function get_programs($active_only = true) {
    try {
        $conn = getConnection();
        $sql = "SELECT * FROM programs";
        if ($active_only) {
            $sql .= " WHERE is_active = 1";
        }
        $sql .= " ORDER BY sort_order ASC";
        $stmt = $conn->query($sql);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * Ambil galeri dengan filter kategori
 */
function get_gallery($category = null, $active_only = true) {
    try {
        $conn = getConnection();
        $sql = "SELECT * FROM gallery WHERE 1=1";
        $params = [];
        
        if ($active_only) {
            $sql .= " AND is_active = 1";
        }
        if ($category) {
            $sql .= " AND category = ?";
            $params[] = $category;
        }
        $sql .= " ORDER BY sort_order ASC, created_at DESC";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * Upload dan compress gambar
 * Return: path relatif gambar atau false jika gagal
 */
function upload_image($file, $folder = '') {
    // Cek error upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'Gagal upload file'];
    }
    
    // Cek ukuran file
    if ($file['size'] > MAX_UPLOAD_SIZE) {
        return ['success' => false, 'message' => 'Ukuran file terlalu besar (max 10MB)'];
    }
    
    // Cek tipe file
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    if (!in_array($mime_type, $allowed_types)) {
        return ['success' => false, 'message' => 'Tipe file tidak didukung (hanya JPG, PNG, GIF, WEBP)'];
    }
    
    // Buat folder jika belum ada
    $upload_dir = UPLOAD_PATH . ($folder ? $folder . '/' : '');
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    // Generate nama file unik
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '_' . time() . '.jpg'; // Selalu simpan sebagai JPG
    $filepath = $upload_dir . $filename;
    
    // Load gambar
    switch ($mime_type) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($file['tmp_name']);
            break;
        case 'image/png':
            $image = imagecreatefrompng($file['tmp_name']);
            break;
        case 'image/gif':
            $image = imagecreatefromgif($file['tmp_name']);
            break;
        case 'image/webp':
            $image = imagecreatefromwebp($file['tmp_name']);
            break;
        default:
            return ['success' => false, 'message' => 'Format gambar tidak didukung'];
    }
    
    if (!$image) {
        return ['success' => false, 'message' => 'Gagal memproses gambar'];
    }
    
    // Dapatkan dimensi asli
    $orig_width = imagesx($image);
    $orig_height = imagesy($image);
    
    // Resize jika lebih besar dari max width
    if ($orig_width > MAX_IMAGE_WIDTH) {
        $new_width = MAX_IMAGE_WIDTH;
        $new_height = floor($orig_height * (MAX_IMAGE_WIDTH / $orig_width));
        
        $resized = imagecreatetruecolor($new_width, $new_height);
        
        // Preserve transparency for PNG
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        
        imagecopyresampled($resized, $image, 0, 0, 0, 0, $new_width, $new_height, $orig_width, $orig_height);
        imagedestroy($image);
        $image = $resized;
    }
    
    // Simpan sebagai JPG dengan kompresi
    $result = imagejpeg($image, $filepath, IMAGE_QUALITY);
    imagedestroy($image);
    
    if (!$result) {
        return ['success' => false, 'message' => 'Gagal menyimpan gambar'];
    }
    
    // Return path relatif
    $relative_path = ($folder ? $folder . '/' : '') . $filename;
    return [
        'success' => true, 
        'path' => $relative_path,
        'url' => UPLOAD_URL . $relative_path,
        'message' => 'Upload berhasil'
    ];
}

/**
 * Hapus file gambar
 */
function delete_image($path) {
    $filepath = UPLOAD_PATH . $path;
    if (file_exists($filepath)) {
        return unlink($filepath);
    }
    return false;
}

/**
 * Sanitize input
 */
function clean($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Cek apakah user sudah login
 */
function is_logged_in() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

/**
 * Redirect ke halaman lain
 */
function redirect($url) {
    header("Location: " . $url);
    exit;
}

/**
 * Set flash message
 */
function set_flash($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

/**
 * Get dan hapus flash message
 */
function get_flash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Generate image URL
 */
function img_url($path) {
    if (empty($path)) {
        return UPLOAD_URL . 'placeholder.jpg';
    }
    // Jika sudah URL lengkap, return as is
    if (strpos($path, 'http') === 0) {
        return $path;
    }
    return UPLOAD_URL . $path;
}
