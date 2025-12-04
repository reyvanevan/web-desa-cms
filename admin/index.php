<?php
$page_title = "Dashboard";
require_once 'includes/header.php';

// Hitung total data
$conn = getConnection();
$total_gallery = $conn->query("SELECT COUNT(*) FROM gallery")->fetchColumn();
$total_programs = $conn->query("SELECT COUNT(*) FROM programs")->fetchColumn();
$total_misi = $conn->query("SELECT COUNT(*) FROM misi")->fetchColumn();
?>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card text-white bg-success h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Total Galeri & Produk</h6>
                        <h2 class="my-2"><?= $total_gallery ?></h2>
                    </div>
                    <i class="fas fa-images fa-3x opacity-50"></i>
                </div>
                <a href="gallery.php" class="text-white text-decoration-none small">Kelola Galeri &rarr;</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-info h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Program Unggulan</h6>
                        <h2 class="my-2"><?= $total_programs ?></h2>
                    </div>
                    <i class="fas fa-tasks fa-3x opacity-50"></i>
                </div>
                <a href="programs.php" class="text-white text-decoration-none small">Kelola Program &rarr;</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-warning h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Poin Misi</h6>
                        <h2 class="my-2"><?= $total_misi ?></h2>
                    </div>
                    <i class="fas fa-list-ul fa-3x opacity-50"></i>
                </div>
                <a href="misi.php" class="text-white text-decoration-none small">Kelola Misi &rarr;</a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle me-2"></i> Informasi Sistem
            </div>
            <div class="card-body">
                <p>Selamat datang di Panel Admin CMS KKN Ciangsana. Gunakan menu di sebelah kiri untuk mengelola konten website.</p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Versi PHP
                        <span class="badge bg-secondary rounded-pill"><?= phpversion() ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Database
                        <span class="badge bg-secondary rounded-pill">MySQL</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Server
                        <span class="badge bg-secondary rounded-pill"><?= $_SERVER['SERVER_SOFTWARE'] ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-link me-2"></i> Pintasan Cepat
            </div>
            <div class="list-group list-group-flush">
                <a href="../index.php" target="_blank" class="list-group-item list-group-item-action">
                    <i class="fas fa-external-link-alt me-2 text-primary"></i> Lihat Website
                </a>
                <a href="settings.php" class="list-group-item list-group-item-action">
                    <i class="fas fa-edit me-2 text-success"></i> Edit Halaman Depan
                </a>
                <a href="gallery.php?action=add" class="list-group-item list-group-item-action">
                    <i class="fas fa-plus me-2 text-info"></i> Tambah Foto Galeri
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
