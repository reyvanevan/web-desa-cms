-- Reset Data
TRUNCATE TABLE struktur_organisasi;

-- 1. Penanggung Jawab (Root)
INSERT INTO struktur_organisasi (id, nama, jabatan, parent_id, sort_order, is_active) VALUES 
(1, 'Udin Saputra, S.H., M.M.', 'Penanggung Jawab', NULL, 1, 1);

-- 2. Level 2 (Penasehat, Pembimbing, Pelindung, Pembina) - Anak dari Penanggung Jawab
INSERT INTO struktur_organisasi (id, nama, jabatan, parent_id, sort_order, is_active) VALUES 
(2, 'Sukrisno, S.T, M.Si', 'Penasehat', 1, 2, 1),
(3, 'Drs. H. Arsyadi, M.Si, Apt.', 'Pembimbing', 1, 3, 1),
(4, 'Achmad Fathoni, S.T., M. PWK', 'Pelindung', 1, 4, 1),
(5, 'Enny Musfiroh Setyarini S.P., M.Ling', 'Pembina', 1, 5, 1);

-- 3. Level 3 (Ketua) - Anak dari Pembina (atau salah satu dari level 2, kita taruh di bawah Pembina agar visualnya di tengah)
-- Atau kita buat Ketua anak dari Penanggung Jawab juga tapi urutan terakhir?
-- Agar visualnya bagus (Tree), Ketua sebaiknya anak dari "Pembina" atau "Penasehat" secara visual, 
-- TAPI secara struktur biasanya Ketua bertanggung jawab ke Penanggung Jawab.
-- Namun untuk visual Tree Chart, jika Ketua sejajar dengan Penasehat, dia akan melebar ke samping.
-- Mari kita buat Ketua sebagai anak dari Penanggung Jawab (ID 1) tapi kita atur CSS nanti atau biarkan user mengatur parentnya.
-- Opsi Terbaik: Ketua adalah pusat operasional.
-- Kita buat Ketua (ID 6) anak dari Penanggung Jawab (ID 1).
INSERT INTO struktur_organisasi (id, nama, jabatan, parent_id, sort_order, is_active) VALUES 
(6, 'Tutik Lestari, S.M., M.M.', 'Ketua', 1, 6, 1);

-- 4. Level 4 (Sekretaris & Bendahara) - Anak dari Ketua
INSERT INTO struktur_organisasi (id, nama, jabatan, parent_id, sort_order, is_active) VALUES 
(7, 'Siti Hadijah, S.Pd.I', 'Sekretaris', 6, 7, 1),
(8, 'Aguslina DM', 'Sekretaris', 6, 8, 1),
(9, 'Dwi Nuraeni', 'Bendahara', 6, 9, 1),
(10, 'Wiwin Indra', 'Bendahara', 6, 10, 1);

-- 5. Level 5 (Seksi-Seksi) - Anak dari Ketua (atau di bawah Sekretaris/Bendahara?)
-- Biasanya Seksi di bawah Ketua.
INSERT INTO struktur_organisasi (id, nama, jabatan, parent_id, sort_order, is_active) VALUES 
(11, 'Maryadi', 'Sie LHK', 6, 11, 1),
(12, 'Awaliyah', 'Sie Pencatatan', 6, 12, 1),
(13, 'Fatimatus Sakdiyah S.E.', 'Sie Humas', 6, 13, 1),
(14, 'Suhaemi', 'Sie Penimbangan', 6, 14, 1),
(15, 'Isnaeni', 'Sie Logistik', 6, 15, 1);
