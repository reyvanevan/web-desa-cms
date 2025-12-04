-- =====================================================
-- Tabel: struktur_organisasi (untuk bagan organisasi dinamis)
-- =====================================================
CREATE TABLE IF NOT EXISTS struktur_organisasi (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    jabatan VARCHAR(100) NOT NULL,
    foto VARCHAR(255),
    parent_id INT DEFAULT NULL, -- Untuk hierarki (Ketua -> Wakil -> dst)
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Insert default struktur (Contoh)
INSERT INTO struktur_organisasi (nama, jabatan, parent_id, sort_order) VALUES 
('Budi Santoso', 'Ketua', NULL, 1),
('Siti Aminah', 'Sekretaris', 1, 2),
('Ahmad Rizki', 'Bendahara', 1, 3),
('Dewi Sartika', 'Koordinator Bank Sampah', 1, 4);
