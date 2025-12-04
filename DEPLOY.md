# Panduan Deploy ke InfinityFree (Gratis)

Berikut adalah langkah-langkah untuk mengonlinekan website KKN Ciangsana menggunakan hosting gratis InfinityFree.

## 1. Persiapan Database
1. Login ke **Client Area** InfinityFree, lalu masuk ke **Control Panel** (VistaPanel).
2. Cari menu **MySQL Databases**.
3. Buat database baru, misalnya beri nama `kkn`.
   - Catat **MySQL Database Name** (biasanya ada prefix, misal: `if0_3456789_kkn`).
   - Catat **MySQL Host Name** (misal: `sql123.infinityfree.com`).
   - Catat **MySQL User Name** (misal: `if0_3456789`).
   - Password database adalah password akun InfinityFree Anda (bisa dilihat di Client Area).
4. Kembali ke Control Panel, buka **phpMyAdmin**.
5. Pilih database yang baru dibuat.
6. Klik tab **Import**, lalu upload file `database/schema.sql` dari project ini.
7. Klik **Go** / **Kirim**. Pastikan semua tabel (`users`, `settings`, `programs`, `misi`, `gallery`) berhasil dibuat.

## 2. Upload File Website
1. Buka **Online File Manager** dari Client Area (atau gunakan FileZilla jika file besar).
2. Masuk ke folder `htdocs`.
3. Hapus file default `index2.html` atau `default.php` jika ada.
4. Upload semua file dan folder dari project ini ke dalam `htdocs`, **KECUALI**:
   - Folder `.git` (jika ada)
   - File `README.md`, `DEPLOY.md`
   - File `index_old.html`
   - *Tips: Anda bisa men-zip semua file menjadi `website.zip`, upload, lalu Extract di File Manager agar lebih cepat.*
5. Pastikan struktur di dalam `htdocs` terlihat seperti ini:
   ```
   htdocs/
   ├── admin/
   ├── config/
   ├── includes/
   ├── uploads/
   ├── index.php
   ├── galeri.php
   ├── sejarah.php
   └── ...
   ```

## 3. Konfigurasi Koneksi Database
1. Di File Manager, buka file `config/database.php`.
2. Edit bagian konfigurasi database sesuai data yang Anda catat di Langkah 1.

```php
// Contoh Konfigurasi InfinityFree
define('DB_HOST', 'sqlxxx.infinityfree.com'); // Sesuaikan dengan MySQL Host Name
define('DB_USER', 'if0_xxxxxxx');             // Sesuaikan dengan MySQL User Name
define('DB_PASS', 'password_akun_anda');      // Password akun InfinityFree
define('DB_NAME', 'if0_xxxxxxx_kkn');         // Sesuaikan dengan MySQL Database Name
```

3. **PENTING:** Sesuaikan juga `BASE_URL` jika diperlukan.
   - Jika website ada di domain utama (misal: `kkn-ciangsana.rf.gd`), ubah menjadi:
     ```php
     define('BASE_URL', '/'); 
     ```
   - Jika di subfolder, sesuaikan path-nya.

## 4. Login Admin
- Buka website Anda: `http://nama-domain-anda.rf.gd/admin`
- Login default:
  - Username: `admin`
  - Password: `admin123`
- **Segera ganti password** setelah berhasil login demi keamanan!

## Catatan Tambahan
- Pastikan folder `uploads/` memiliki permission yang bisa ditulisi (biasanya 755 atau 777 sudah default di InfinityFree).
- Jika gambar tidak muncul, cek kembali `BASE_URL` di `config/database.php`.
