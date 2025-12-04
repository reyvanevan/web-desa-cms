<?php
// File ini untuk mengecek path dan URL gambar di InfinityFree
// Upload file ini ke folder htdocs (sejajar dengan index.php)
// Lalu buka di browser: http://domain-anda.rf.gd/test_image.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/database.php';

echo "<h1>Tes Path & URL Gambar</h1>";

echo "<h3>Konfigurasi Saat Ini:</h3>";
echo "<ul>";
echo "<li><b>BASE_URL:</b> " . BASE_URL . "</li>";
echo "<li><b>UPLOAD_PATH:</b> " . UPLOAD_PATH . "</li>";
echo "<li><b>UPLOAD_URL:</b> " . UPLOAD_URL . "</li>";
echo "<li><b>Document Root:</b> " . $_SERVER['DOCUMENT_ROOT'] . "</li>";
echo "</ul>";

echo "<h3>Cek Folder Uploads:</h3>";
$real_upload_path = realpath(UPLOAD_PATH);
if ($real_upload_path) {
    echo "<p style='color: green;'>✅ Folder uploads ditemukan di: " . $real_upload_path . "</p>";
    
    // Cek permission
    if (is_writable($real_upload_path)) {
        echo "<p style='color: green;'>✅ Folder uploads bisa ditulisi (Writable).</p>";
    } else {
        echo "<p style='color: red;'>❌ Folder uploads TIDAK bisa ditulisi (Not Writable). Cek permission (chmod 755/777).</p>";
    }

    // List file di folder uploads
    echo "<h4>Isi Folder Uploads:</h4>";
    $files = scandir($real_upload_path);
    echo "<ul>";
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            echo "<li>" . $file . "</li>";
        }
    }
    echo "</ul>";

} else {
    echo "<p style='color: red;'>❌ Folder uploads TIDAK ditemukan di path: " . UPLOAD_PATH . "</p>";
    echo "<p>Pastikan Anda sudah membuat folder <b>uploads</b> di root website (sejajar dengan index.php).</p>";
}

echo "<h3>Tes URL Gambar:</h3>";
echo "<p>Coba akses URL ini secara manual di browser:</p>";
echo "<a href='" . UPLOAD_URL . "placeholder.jpg' target='_blank'>" . UPLOAD_URL . "placeholder.jpg</a>";

?>