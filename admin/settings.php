<?php
$page_title = "Pengaturan Umum";
require_once 'includes/header.php';

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $success = true;
    
    // Loop semua post data
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'setting_') === 0) {
            $setting_key = substr($key, 8); // remove 'setting_' prefix
            if (!set_setting($setting_key, $value)) {
                $success = false;
            }
        }
    }

    // Handle File Uploads
    $uploads = [
        'hero_bg' => 'hero',
        'about_image' => 'about',
        'sejarah_bg' => 'hero',
        'galeri_bg' => 'hero'
    ];

    foreach ($uploads as $field => $folder) {
        if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
            $upload = upload_image($_FILES[$field], $folder);
            if ($upload['success']) {
                set_setting($field, $upload['path'], 'image');
            } else {
                $success = false;
                set_flash('danger', "Gagal upload $field: " . $upload['message']);
            }
        }
    }

    if ($success) {
        set_flash('success', 'Pengaturan berhasil disimpan');
        redirect('settings.php');
    }
}
?>

<form method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="list-group sticky-top" style="top: 20px; z-index: 1;">
                <a href="#hero" class="list-group-item list-group-item-action active" data-bs-toggle="list">Hero Section</a>
                <a href="#stats" class="list-group-item list-group-item-action" data-bs-toggle="list">Statistik</a>
                <a href="#about" class="list-group-item list-group-item-action" data-bs-toggle="list">Tentang Kami</a>
                <a href="#sejarah" class="list-group-item list-group-item-action" data-bs-toggle="list">Halaman Sejarah</a>
                <a href="#cta" class="list-group-item list-group-item-action" data-bs-toggle="list">Call to Action</a>
                <a href="#footer" class="list-group-item list-group-item-action" data-bs-toggle="list">Footer & Kontak</a>
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-3 py-2 fw-bold">Simpan Semua Perubahan</button>
        </div>
        
        <div class="col-md-9">
            <div class="tab-content">
                
                <!-- HERO SECTION -->
                <div class="tab-pane fade show active" id="hero">
                    <div class="card">
                        <div class="card-header">Pengaturan Hero (Halaman Depan)</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Judul Utama</label>
                                <input type="text" name="setting_hero_title" class="form-control" value="<?= get_setting('hero_title') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Sub-Judul</label>
                                <textarea name="setting_hero_subtitle" class="form-control" rows="2"><?= get_setting('hero_subtitle') ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Background Image</label>
                                <input type="file" name="hero_bg" class="form-control">
                                <?php if ($bg = get_setting('hero_bg')): ?>
                                    <div class="mt-2">
                                        <img src="<?= img_url($bg) ?>" height="100" class="rounded">
                                        <small class="text-muted d-block">Gambar saat ini</small>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STATS SECTION -->
                <div class="tab-pane fade" id="stats">
                    <div class="card">
                        <div class="card-header">Data Statistik</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Angka Tahun</label>
                                    <input type="text" name="setting_stat_year" class="form-control" value="<?= get_setting('stat_year') ?>">
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label class="form-label fw-bold">Label Tahun</label>
                                    <input type="text" name="setting_stat_year_label" class="form-control" value="<?= get_setting('stat_year_label') ?>">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Angka Program</label>
                                    <input type="text" name="setting_stat_program" class="form-control" value="<?= get_setting('stat_program') ?>">
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label class="form-label fw-bold">Label Program</label>
                                    <input type="text" name="setting_stat_program_label" class="form-control" value="<?= get_setting('stat_program_label') ?>">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Angka Dedikasi</label>
                                    <input type="text" name="setting_stat_dedication" class="form-control" value="<?= get_setting('stat_dedication') ?>">
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label class="form-label fw-bold">Label Dedikasi</label>
                                    <input type="text" name="setting_stat_dedication_label" class="form-control" value="<?= get_setting('stat_dedication_label') ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ABOUT SECTION -->
                <div class="tab-pane fade" id="about">
                    <div class="card">
                        <div class="card-header">Tentang Kami (Halaman Depan)</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Judul Section</label>
                                <input type="text" name="setting_about_title" class="form-control" value="<?= get_setting('about_title') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Deskripsi Singkat</label>
                                <textarea name="setting_about_description" class="form-control" rows="5"><?= get_setting('about_description') ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Gambar About</label>
                                <input type="file" name="about_image" class="form-control">
                                <?php if ($img = get_setting('about_image')): ?>
                                    <div class="mt-2">
                                        <img src="<?= img_url($img) ?>" height="100" class="rounded">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEJARAH PAGE -->
                <div class="tab-pane fade" id="sejarah">
                    <div class="card">
                        <div class="card-header">Halaman Sejarah & Visi Misi</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Header Background</label>
                                <input type="file" name="sejarah_bg" class="form-control">
                                <?php if ($bg = get_setting('sejarah_bg')): ?>
                                    <div class="mt-2">
                                        <img src="<?= img_url($bg) ?>" height="100" class="rounded">
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Konten Latar Belakang (HTML Allowed)</label>
                                <textarea name="setting_sejarah_content" class="form-control" rows="8"><?= get_setting('sejarah_content') ?></textarea>
                                <small class="text-muted">Gunakan tag &lt;p&gt; untuk paragraf dan &lt;strong&gt; untuk tebal.</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Visi</label>
                                <textarea name="setting_visi" class="form-control" rows="3"><?= get_setting('visi') ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CTA SECTION -->
                <div class="tab-pane fade" id="cta">
                    <div class="card">
                        <div class="card-header">Call to Action (Bawah Halaman)</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Judul CTA</label>
                                <input type="text" name="setting_cta_title" class="form-control" value="<?= get_setting('cta_title') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Sub-Judul CTA</label>
                                <input type="text" name="setting_cta_subtitle" class="form-control" value="<?= get_setting('cta_subtitle') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nomor WhatsApp (Format: 628xxx)</label>
                                <input type="text" name="setting_cta_whatsapp" class="form-control" value="<?= get_setting('cta_whatsapp') ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FOOTER SECTION -->
                <div class="tab-pane fade" id="footer">
                    <div class="card">
                        <div class="card-header">Footer & Kontak</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Alamat Lengkap</label>
                                <textarea name="setting_footer_alamat" class="form-control" rows="3"><?= get_setting('footer_alamat') ?></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Nomor Telepon</label>
                                    <input type="text" name="setting_footer_telepon" class="form-control" value="<?= get_setting('footer_telepon') ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Email</label>
                                    <input type="email" name="setting_footer_email" class="form-control" value="<?= get_setting('footer_email') ?>">
                                </div>
                            </div>
                            <hr>
                            <h6 class="fw-bold">Social Media Links</h6>
                            <div class="mb-3">
                                <label class="form-label">Instagram URL</label>
                                <input type="text" name="setting_footer_instagram" class="form-control" value="<?= get_setting('footer_instagram') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Facebook URL</label>
                                <input type="text" name="setting_footer_facebook" class="form-control" value="<?= get_setting('footer_facebook') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">YouTube URL</label>
                                <input type="text" name="setting_footer_youtube" class="form-control" value="<?= get_setting('footer_youtube') ?>">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</form>

<?php require_once 'includes/footer.php'; ?>
