-- Kosongkan tabel terlebih dahulu (Opsional, hati-hati jika sudah ada data lain)
TRUNCATE TABLE struktur_organisasi;

-- Insert Data Pengurus Periode 2023 - 2028
INSERT INTO struktur_organisasi (nama, jabatan, sort_order, is_active) VALUES 
('Udin Saputra, S.H., M.M.', 'Penanggung Jawab', 1, 1),
('Sukrisno, S.T, M.Si', 'Penasehat', 2, 1),
('Drs. H. Arsyadi, M.Si, Apt.', 'Pembimbing', 3, 1),
('Achmad Fathoni, S.T., M. PWK', 'Pelindung', 4, 1),
('Enny Musfiroh Setyarini S.P., M.Ling', 'Pembina', 5, 1),
('Tutik Lestari, S.M., M.M.', 'Ketua', 6, 1),
('Siti Hadijah, S.Pd.I', 'Sekretaris', 7, 1),
('Aguslina DM', 'Sekretaris', 8, 1),
('Dwi Nuraeni', 'Bendahara', 9, 1),
('Wiwin Indra', 'Bendahara', 10, 1),
('Maryadi', 'Sie LHK', 11, 1),
('Awaliyah', 'Sie Pencatatan', 12, 1),
('Fatimatus Sakdiyah S.E.', 'Sie Humas', 13, 1),
('Suhaemi', 'Sie Penimbangan', 14, 1),
('Isnaeni', 'Sie Logistik', 15, 1);
