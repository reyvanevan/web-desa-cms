<?php
$page_title = "Beranda";
require_once 'includes/header.php';

// Ambil data program unggulan
$programs = get_programs();

// Ambil data galeri produk (limit 4)
$products = get_gallery('produk');
?>

    <section id="home" class="hero">
        <div class="hero-bg" style="background-image: url('<?= img_url(get_setting('hero_bg', 'https://placehold.co/1920x1080?text=Foto+Landscape+Desa+Keren')) ?>');"></div>
        <div class="hero-content text-center" data-aos="fade-up" data-aos-duration="1000">
            <span class="hero-subtitle text-uppercase tracking-wider mb-2 d-block fw-bold text-warning">Dipersembahkan
                oleh KKN Sinergi Peduli</span>
            <h1><?= get_setting('hero_title', 'Inovasi Hijau Untuk<br>Masa Depan Desa') ?></h1>
            <p class="lead mb-4 opacity-75"><?= get_setting('hero_subtitle', 'Bersinergi membangun lingkungan mandiri, kreatif, dan berkelanjutan di RW 21 Ciangsana.') ?></p>
            <a href="#about" class="btn-glow">Jelajahi Profil</a>
        </div>
    </section>

    <div class="container">
        <div class="stats-box" data-aos="fade-up" data-aos-delay="100">
            <div class="row text-center">
                <div class="col-md-4 mb-3 mb-md-0 border-end">
                    <div class="stat-item">
                        <h3><?= get_setting('stat_year', '2018') ?></h3>
                        <p class="mb-0 text-muted"><?= get_setting('stat_year_label', 'Tahun Berdiri') ?></p>
                    </div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0 border-end">
                    <div class="stat-item">
                        <h3><?= get_setting('stat_program', '3+') ?></h3>
                        <p class="mb-0 text-muted"><?= get_setting('stat_program_label', 'Program Utama') ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <h3><?= get_setting('stat_dedication', '100%') ?></h3>
                        <p class="mb-0 text-muted"><?= get_setting('stat_dedication_label', 'Dedikasi Warga') ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="about" style="padding: 100px 0;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                    <img src="<?= img_url(get_setting('about_image', 'https://placehold.co/600x600?text=Foto+Team+atau+Posko')) ?>"
                        class="img-fluid rounded-4 shadow-lg" alt="About Us">
                </div>
                <div class="col-lg-6 ps-lg-5" data-aos="fade-left">
                    <h5 class="text-uppercase text-primary fw-bold mb-3">Siapa Kami?</h5>
                    <h2 class="display-6 fw-bold mb-4"><?= get_setting('about_title', 'Membangun Budaya Cinta Lingkungan') ?></h2>
                    <p class="text-muted">
                        <?= nl2br(get_setting('about_description', 'KRL CINTA RW 21 Desa Ciangsana bukan sekadar organisasi, tapi sebuah gerakan...')) ?>
                    </p>
                    <a href="sejarah.php" class="text-primary fw-bold text-decoration-none">Baca Sejarah Lengkap <i
                            class="fas fa-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
    </section>

    <section id="kegiatan" class="bg-light" style="padding: 100px 0;">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h5 class="text-primary fw-bold">Program Unggulan</h5>
                <h2>Aksi Nyata Kami</h2>
            </div>

            <div class="row g-4">
                <?php if (empty($programs)): ?>
                    <!-- Default Content if Database Empty -->
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="card-program">
                            <div class="card-img-wrapper">
                                <img src="https://placehold.co/400x300?text=Edukasi" alt="Edukasi">
                            </div>
                            <div class="card-body p-4">
                                <h4>Edukasi</h4>
                                <p class="text-muted small">Membentuk pola pikir sadar lingkungan sejak dini melalui sosialisasi rutin ke warga.</p>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($programs as $index => $program): ?>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?= ($index + 1) * 100 ?>">
                        <div class="card-program">
                            <div class="card-img-wrapper d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                                <i class="<?= clean($program['icon']) ?> fa-5x text-primary"></i>
                            </div>
                            <div class="card-body p-4">
                                <h4><?= clean($program['title']) ?></h4>
                                <p class="text-muted small"><?= clean($program['description']) ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section id="produk" style="padding: 100px 0;">
        <div class="container">
            <div class="row mb-5 align-items-end">
                <div class="col-md-8" data-aos="fade-right">
                    <h5 class="text-primary fw-bold">Galeri Produk</h5>
                    <h2>Kreativitas Tanpa Batas</h2>
                </div>
                <div class="col-md-4 text-md-end" data-aos="fade-left">
                    <a href="galeri.php" class="btn btn-outline-dark rounded-pill px-4">Lihat Semua</a>
                </div>
            </div>

            <div class="row g-3">
                <?php if (!empty($products)): ?>
                    <div class="col-md-8">
                        <img src="<?= img_url($products[0]['image']) ?>" class="gallery-img"
                            style="height: 515px;" data-aos="zoom-in">
                    </div>
                    <div class="col-md-4">
                        <div class="row g-3">
                            <?php if (isset($products[1])): ?>
                            <div class="col-12">
                                <img src="<?= img_url($products[1]['image']) ?>" class="gallery-img"
                                    data-aos="zoom-in" data-aos-delay="100">
                            </div>
                            <?php endif; ?>
                            <?php if (isset($products[2])): ?>
                            <div class="col-12">
                                <img src="<?= img_url($products[2]['image']) ?>" class="gallery-img"
                                    data-aos="zoom-in" data-aos-delay="200">
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Fallback Content -->
                    <div class="col-md-8">
                        <img src="https://placehold.co/800x500?text=Produk+Utama+Tas+Cantik" class="gallery-img"
                            style="height: 515px;" data-aos="zoom-in">
                    </div>
                    <div class="col-md-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <img src="https://placehold.co/400x250?text=Kerajinan+Tangan" class="gallery-img"
                                    data-aos="zoom-in" data-aos-delay="100">
                            </div>
                            <div class="col-12">
                                <img src="https://placehold.co/400x250?text=Pupuk+Kompos" class="gallery-img"
                                    data-aos="zoom-in" data-aos-delay="200">
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="py-5"
        style="background: linear-gradient(to right, var(--primary), var(--secondary)); color: white;">
        <div class="container text-center py-4" data-aos="fade-up">
            <h2 class="fw-bold mb-3"><?= get_setting('cta_title', 'Siap Berkolaborasi?') ?></h2>
            <p class="mb-4"><?= get_setting('cta_subtitle', 'Hubungi kami untuk studi banding, kerjasama, atau informasi lebih lanjut.') ?></p>
            <a href="https://wa.me/<?= get_setting('cta_whatsapp', '6281234567890') ?>" class="btn btn-light rounded-pill px-5 fw-bold text-success shadow">Kontak WhatsApp</a>
        </div>
    </section>

<?php require_once 'includes/footer.php'; ?>
