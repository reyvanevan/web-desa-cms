-- =====================================================
-- Database Schema untuk CMS KKN Ciangsana
-- Jalankan di phpMyAdmin atau MySQL CLI
-- =====================================================

-- Buat database
CREATE DATABASE IF NOT EXISTS kkn_ciangsana 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE kkn_ciangsana;

-- =====================================================
-- Tabel: users (untuk login admin)
-- =====================================================
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Insert default admin (password: admin123)
-- PENTING: Ganti password ini setelah pertama kali login!
INSERT INTO users (username, password, nama_lengkap) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator');

-- =====================================================
-- Tabel: settings (untuk konten statis)
-- =====================================================
CREATE TABLE IF NOT EXISTS settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    setting_type ENUM('text', 'textarea', 'image', 'number', 'html') DEFAULT 'text',
    setting_group VARCHAR(50) DEFAULT 'general',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Insert default settings
INSERT INTO settings (setting_key, setting_value, setting_type, setting_group) VALUES 
-- Hero Section
('hero_title', 'Inovasi Hijau Untuk Masa Depan Desa', 'text', 'hero'),
('hero_subtitle', 'Bersinergi membangun ekonomi kreatif berbasis lingkungan', 'text', 'hero'),
('hero_description', 'KKN Tematik UPN Veteran Jakarta bersama masyarakat Ciangsana mengembangkan solusi kreatif untuk pengelolaan sampah dan pemberdayaan ekonomi desa.', 'textarea', 'hero'),
('hero_bg', '', 'image', 'hero'),

-- Statistik
('stat_year', '2018', 'text', 'statistik'),
('stat_year_label', 'Tahun Berdiri', 'text', 'statistik'),
('stat_program', '3+', 'text', 'statistik'),
('stat_program_label', 'Program Aktif', 'text', 'statistik'),
('stat_dedication', '100%', 'text', 'statistik'),
('stat_dedication_label', 'Dedikasi', 'text', 'statistik'),

-- About Section
('about_title', 'Tentang Bank Sampah Sehati', 'text', 'about'),
('about_description', 'Bank Sampah Sehati adalah inisiatif pengelolaan sampah berbasis masyarakat yang berdiri sejak tahun 2018 di Desa Ciangsana, Kecamatan Gunung Putri, Kabupaten Bogor. Didirikan dengan semangat gotong royong, Bank Sampah Sehati telah menjadi pionir dalam mengubah paradigma masyarakat tentang sampah dari "beban" menjadi "berkah".', 'textarea', 'about'),
('about_image', '', 'image', 'about'),

-- Visi Misi
('visi', 'Lingkunganku BERSIH, Masyarakatku SEHAT, Ekonomiku MANDIRI, Alamku LESTARI', 'textarea', 'visi_misi'),

-- CTA Section
('cta_title', 'Bergabunglah Bersama Kami', 'text', 'cta'),
('cta_subtitle', 'Mari bersama-sama membangun desa yang lebih hijau dan berkelanjutan', 'text', 'cta'),
('cta_whatsapp', '6281234567890', 'text', 'cta'),

-- Footer
('footer_alamat', 'Jl. Ciangsana No. 123, Desa Ciangsana, Kec. Gunung Putri, Kab. Bogor, Jawa Barat 16968', 'textarea', 'footer'),
('footer_telepon', '(021) 1234-5678', 'text', 'footer'),
('footer_email', 'banksampahsehati@gmail.com', 'text', 'footer'),
('footer_facebook', '#', 'text', 'footer'),
('footer_instagram', '#', 'text', 'footer'),
('footer_youtube', '#', 'text', 'footer');

-- =====================================================
-- Tabel: misi (daftar misi, bisa ditambah/hapus)
-- =====================================================
CREATE TABLE IF NOT EXISTS misi (
    id INT PRIMARY KEY AUTO_INCREMENT,
    content TEXT NOT NULL,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Insert default misi
INSERT INTO misi (content, sort_order) VALUES 
('Meningkatkan kesadaran masyarakat tentang pentingnya pengelolaan sampah yang baik dan benar', 1),
('Mengurangi volume sampah yang dibuang ke TPA melalui sistem 3R (Reduce, Reuse, Recycle)', 2),
('Memberdayakan masyarakat melalui kegiatan ekonomi kreatif berbasis pengolahan sampah', 3),
('Menciptakan lingkungan yang bersih, sehat, dan nyaman bagi seluruh warga desa', 4),
('Membangun kemitraan dengan berbagai pihak untuk pengembangan program bank sampah', 5),
('Menjadi contoh dan inspirasi bagi desa-desa lain dalam pengelolaan sampah mandiri', 6);

-- =====================================================
-- Tabel: programs (program unggulan)
-- =====================================================
CREATE TABLE IF NOT EXISTS programs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    icon VARCHAR(50) DEFAULT 'fa-star',
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Insert default programs
INSERT INTO programs (title, description, icon, sort_order) VALUES 
('Tabungan Sampah', 'Program tabungan sampah untuk warga dengan sistem poin yang dapat ditukarkan dengan uang atau barang kebutuhan sehari-hari.', 'fa-piggy-bank', 1),
('Kerajinan Daur Ulang', 'Pelatihan pembuatan kerajinan tangan dari bahan daur ulang seperti tas, dompet, dan aksesoris dari kemasan bekas.', 'fa-hands', 2),
('Edukasi Lingkungan', 'Program edukasi untuk anak-anak dan masyarakat tentang pentingnya menjaga lingkungan dan cara memilah sampah.', 'fa-graduation-cap', 3);

-- =====================================================
-- Tabel: gallery (galeri foto & prestasi)
-- =====================================================
CREATE TABLE IF NOT EXISTS gallery (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    image VARCHAR(255) NOT NULL,
    category ENUM('prestasi', 'produk', 'kegiatan') NOT NULL DEFAULT 'kegiatan',
    is_active TINYINT(1) DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Insert sample gallery items
INSERT INTO gallery (title, description, image, category, sort_order) VALUES 
('Juara 1 Lomba Bank Sampah', 'Penghargaan tingkat Kabupaten Bogor 2023', 'sample/prestasi1.jpg', 'prestasi', 1),
('Tas Daur Ulang', 'Produk unggulan dari kemasan plastik bekas', 'sample/produk1.jpg', 'produk', 1),
('Pelatihan Warga', 'Kegiatan pelatihan pemilahan sampah', 'sample/kegiatan1.jpg', 'kegiatan', 1);

-- =====================================================
-- Index untuk performa
-- =====================================================
CREATE INDEX idx_settings_key ON settings(setting_key);
CREATE INDEX idx_settings_group ON settings(setting_group);
CREATE INDEX idx_gallery_category ON gallery(category);
CREATE INDEX idx_gallery_active ON gallery(is_active);
CREATE INDEX idx_programs_active ON programs(is_active);
CREATE INDEX idx_misi_order ON misi(sort_order);
