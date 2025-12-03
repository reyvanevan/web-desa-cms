# KKN Ciangsana CMS

Website profil desa dengan fitur CMS (Content Management System) sederhana menggunakan PHP Native.

## Fitur
- **Halaman Depan Dinamis**: Hero section, About, Statistik, Program, Galeri, dan Footer bisa diedit dari admin.
- **Manajemen Galeri**: Upload foto kegiatan, produk, dan prestasi (resize & compress otomatis).
- **Manajemen Program**: Tambah/Edit/Hapus program kerja dengan ikon FontAwesome.
- **Manajemen Misi**: Tambah/Edit/Hapus poin-poin misi.
- **Pengaturan Umum**: Ganti judul, deskripsi, kontak, dan link sosmed.

## Instalasi (XAMPP)

1. **Database**:
   - Buat database baru di phpMyAdmin bernama `kkn_ciangsana`.
   - Import file `database/schema.sql` ke dalam database tersebut.

2. **Konfigurasi**:
   - File konfigurasi ada di `config/database.php`.
   - Default user: `root`, password: `` (kosong).

3. **Akses Admin**:
   - Buka browser dan akses `http://localhost/kkn-ciangsana/admin`
   - **Username**: `admin`
   - **Password**: `admin123`

## Struktur Folder
- `admin/` - Halaman panel admin (CRUD).
- `config/` - Koneksi database.
- `database/` - File SQL untuk import database.
- `includes/` - Fungsi helper dan template parsial (header/footer).
- `uploads/` - Folder penyimpanan gambar yang diupload.

## Catatan Teknis
- Gambar yang diupload akan otomatis di-resize max lebar 1200px dan dikompres kualitas 80% untuk menjaga performa website.
- Menggunakan Bootstrap 5 untuk styling.
- Menggunakan PDO untuk keamanan database.
