<?php
$page_title = "Sejarah & Visi Misi";
require_once 'includes/header.php';

// Ambil data misi
$misi_list = get_misi();
?>

    <header class="page-header" style="background-image: linear-gradient(rgba(0, 105, 92, 0.9), rgba(0, 77, 64, 0.9)), url('<?= img_url(get_setting('sejarah_bg', 'https://placehold.co/1920x600?text=Sejarah+Kami')) ?>');">
        <div class="container" data-aos="fade-up">
            <h1>Sejarah & Visi Misi</h1>
            <p class="lead opacity-75">Fondasi dan semangat kami dalam membangun lingkungan yang berkelanjutan.</p>
        </div>
    </header>

    <section class="mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <div class="content-card" data-aos="fade-up">
                        <h3 class="fw-bold mb-4 text-primary"><i class="fas fa-history me-2"></i>Latar Belakang</h3>
                        <div class="text-muted">
                            <?= get_setting('sejarah_content', '<p>Berawal dari keresahan warga RW 021 Komplek TWP TNI AL Ciangsana Bogor akan kondisi lingkungan sekitarnya yang masih kotor dan kurang mendapat perhatian serius, maka pada tanggal <strong>23 Desember 2018</strong> dibentuklah Bank Sampah CINTA.</p><p>Paradigma bahwa sampah adalah buangan yang tidak berguna perlu diubah. Bank Sampah CINTA hadir sebagai jawaban untuk mengubah paradigma "Buang Sampah" menjadi <strong>"Tabung Sampah"</strong>. Melalui bank sampah ini, warga diajak untuk memilah sampah dari rumah, yang kemudian tidak hanya menciptakan lingkungan bersih tetapi juga memberikan nilai ekonomi.</p><p class="mb-0 fst-italic">"Bersih Lingkunganku, Sejahtera Keluargaku"</p>') ?>
                        </div>
                    </div>

                    <div class="content-card" data-aos="fade-up" data-aos-delay="100">
                        <h3 class="fw-bold mb-4 text-primary"><i class="fas fa-eye me-2"></i>Visi Kami</h3>
                        <div class="vision-box text-center">
                            <h2 class="display-6 fst-italic fw-bold">"<?= get_setting('visi', 'Lingkunganku BERSIH dan SEJAHTERA, Hidup semakin SEHAT') ?>"</h2>
                        </div>
                    </div>

                    <div class="content-card" data-aos="fade-up" data-aos-delay="200">
                        <h3 class="fw-bold mb-4 text-primary"><i class="fas fa-bullseye me-2"></i>Misi Kami</h3>
                        <ul class="list-group list-group-flush">
                            <?php if (empty($misi_list)): ?>
                                <li class="list-group-item bg-transparent"><i class="fas fa-check-circle text-success me-3"></i>Melestarikan lingkungan yang asri dan nyaman.</li>
                                <li class="list-group-item bg-transparent"><i class="fas fa-check-circle text-success me-3"></i>Membudayakan hidup bersih, sejahtera, dan sehat bagi seluruh warga.</li>
                            <?php else: ?>
                                <?php foreach ($misi_list as $misi): ?>
                                <li class="list-group-item bg-transparent"><i class="fas fa-check-circle text-success me-3"></i><?= clean($misi['content']) ?></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </section>

<?php require_once 'includes/footer.php'; ?>
