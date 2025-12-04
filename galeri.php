<?php
$page_title = "Galeri & Prestasi";
require_once 'includes/header.php';

// Ambil semua data galeri
$all_gallery = get_gallery();

// Filter data untuk tab-tab
$prestasi = array_filter($all_gallery, function($item) { return $item['category'] == 'prestasi'; });
$produk = array_filter($all_gallery, function($item) { return $item['category'] == 'produk'; });
$kegiatan = array_filter($all_gallery, function($item) { return $item['category'] == 'kegiatan'; });
?>

    <header class="page-header" style="background-image: url('<?= img_url(get_setting('galeri_bg', 'https://placehold.co/1920x600?text=Header+Background')) ?>');">
        <div class="container" data-aos="fade-up">
            <span class="text-uppercase tracking-wider mb-2 d-block fw-bold text-warning"
                style="letter-spacing: 3px; font-size: 0.9rem;">Dipersembahkan oleh KKN Sinergi Peduli</span>
            <h1>Galeri & Prestasi</h1>
            <p class="lead opacity-75">Dokumentasi perjalanan, inovasi produk, dan pencapaian KRL CINTA.</p>
        </div>
    </header>

    <div class="container mb-5">

        <div class="row justify-content-center mb-5" data-aos="fade-up">
            <div class="col-auto">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item"><button class="nav-link active" id="pills-all-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-all" type="button">Semua</button></li>
                    <li class="nav-item"><button class="nav-link" id="pills-prestasi-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-prestasi" type="button">Prestasi</button></li>
                    <li class="nav-item"><button class="nav-link" id="pills-produk-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-produk" type="button">Produk Kreatif</button></li>
                    <li class="nav-item"><button class="nav-link" id="pills-kegiatan-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-kegiatan" type="button">Kegiatan</button></li>
                </ul>
            </div>
        </div>

        <div class="tab-content" id="pills-tabContent">

            <!-- TAB SEMUA -->
            <div class="tab-pane fade show active" id="pills-all">
                <div class="row g-4">
                    <?php if (empty($all_gallery)): ?>
                        <div class="col-12 text-center py-5 text-muted">Belum ada data galeri.</div>
                    <?php else: ?>
                        <?php foreach ($all_gallery as $index => $item): ?>
                        <div class="col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="<?= ($index % 3) * 100 ?>">
                            <div class="gallery-card">
                                <div class="gallery-img-wrapper">
                                    <span class="gallery-badge"><?= ucfirst($item['category']) ?></span>
                                    <img src="<?= img_url($item['image']) ?>" alt="<?= clean($item['title']) ?>">
                                </div>
                                <div class="gallery-body">
                                    <h5><?= clean($item['title']) ?></h5>
                                    <p class="text-muted small mb-0"><?= clean($item['description']) ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- TAB PRESTASI -->
            <div class="tab-pane fade" id="pills-prestasi">
                <div class="row g-4">
                    <?php if (empty($prestasi)): ?>
                        <div class="col-12 text-center py-5 text-muted">Belum ada data prestasi.</div>
                    <?php else: ?>
                        <?php foreach ($prestasi as $item): ?>
                        <div class="col-md-4">
                            <div class="gallery-card">
                                <div class="gallery-img-wrapper">
                                    <img src="<?= img_url($item['image']) ?>" alt="<?= clean($item['title']) ?>">
                                </div>
                                <div class="gallery-body">
                                    <h5><?= clean($item['title']) ?></h5>
                                    <p class="text-muted small"><?= clean($item['description']) ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- TAB PRODUK -->
            <div class="tab-pane fade" id="pills-produk">
                <div class="row g-4">
                    <?php if (empty($produk)): ?>
                        <div class="col-12 text-center py-5 text-muted">Belum ada data produk.</div>
                    <?php else: ?>
                        <?php foreach ($produk as $item): ?>
                        <div class="col-md-3 col-6">
                            <div class="gallery-card">
                                <div class="gallery-img-wrapper"><img src="<?= img_url($item['image']) ?>" alt="<?= clean($item['title']) ?>"></div>
                                <div class="gallery-body py-3 text-center">
                                    <h6><?= clean($item['title']) ?></h6>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- TAB KEGIATAN -->
            <div class="tab-pane fade" id="pills-kegiatan">
                <div class="alert alert-light text-center border">
                    <i class="fas fa-camera me-2"></i> Dokumentasi kegiatan Bank Sampah, Kunjungan Tamu, dan Edukasi Sekolah.
                </div>
                <div class="row g-3">
                    <?php if (empty($kegiatan)): ?>
                        <div class="col-12 text-center py-5 text-muted">Belum ada data kegiatan.</div>
                    <?php else: ?>
                        <?php foreach ($kegiatan as $item): ?>
                        <div class="col-md-4">
                            <div class="gallery-card">
                                <div class="gallery-img-wrapper"><img src="<?= img_url($item['image']) ?>" alt="<?= clean($item['title']) ?>"></div>
                                <div class="gallery-body">
                                    <h5><?= clean($item['title']) ?></h5>
                                    <p class="text-muted small"><?= clean($item['description']) ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

    <section class="py-5 mt-5" style="background-color: var(--bg-card); border-top: 1px solid var(--border-color);">
        <div class="container text-center">
            <h3 class="fw-bold mb-3">Tertarik dengan Produk Kami?</h3>
            <p class="text-muted mb-4">Hubungi kami untuk pemesanan produk daur ulang atau studi banding.</p>
            <a href="https://wa.me/<?= get_setting('cta_whatsapp', '6281234567890') ?>" class="btn-glow">Hubungi WhatsApp</a>
        </div>
    </section>

<?php require_once 'includes/footer.php'; ?>
