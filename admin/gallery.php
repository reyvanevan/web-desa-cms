<?php
$page_title = "Kelola Galeri & Produk";
require_once '../config/database.php';
require_once '../includes/functions.php';

session_start();
if (!is_logged_in()) {
    redirect('login.php');
}

$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? 0;

// Handle Delete
if ($action == 'delete' && $id) {
    try {
        $conn = getConnection();
        // Get image path first to delete file
        $stmt = $conn->prepare("SELECT image FROM gallery WHERE id = ?");
        $stmt->execute([$id]);
        $item = $stmt->fetch();
        
        if ($item) {
            delete_image($item['image']);
            $conn->prepare("DELETE FROM gallery WHERE id = ?")->execute([$id]);
            set_flash('success', 'Item berhasil dihapus');
        }
    } catch (PDOException $e) {
        set_flash('danger', 'Gagal menghapus item');
    }
    redirect('gallery.php');
}

// Handle Form Submit (Add/Edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = clean($_POST['title']);
    $description = clean($_POST['description']);
    $category = clean($_POST['category']);
    $sort_order = (int)$_POST['sort_order'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    $image_path = '';
    $upload_error = '';

    // Handle Image Upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload = upload_image($_FILES['image'], 'gallery');
        if ($upload['success']) {
            $image_path = $upload['path'];
        } else {
            $upload_error = $upload['message'];
        }
    }

    if ($upload_error) {
        set_flash('danger', $upload_error);
    } else {
        try {
            $conn = getConnection();
            if ($action == 'add') {
                if (empty($image_path)) {
                    set_flash('danger', 'Gambar wajib diupload untuk item baru');
                } else {
                    $stmt = $conn->prepare("INSERT INTO gallery (title, description, category, image, sort_order, is_active) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$title, $description, $category, $image_path, $sort_order, $is_active]);
                    set_flash('success', 'Item berhasil ditambahkan');
                    redirect('gallery.php');
                }
            } elseif ($action == 'edit' && $id) {
                $sql = "UPDATE gallery SET title=?, description=?, category=?, sort_order=?, is_active=?";
                $params = [$title, $description, $category, $sort_order, $is_active];
                
                if ($image_path) {
                    $sql .= ", image=?";
                    $params[] = $image_path;
                    
                    // Delete old image
                    $stmt = $conn->prepare("SELECT image FROM gallery WHERE id = ?");
                    $stmt->execute([$id]);
                    $old_item = $stmt->fetch();
                    if ($old_item) delete_image($old_item['image']);
                }
                
                $sql .= " WHERE id=?";
                $params[] = $id;
                
                $stmt = $conn->prepare($sql);
                $stmt->execute($params);
                set_flash('success', 'Item berhasil diperbarui');
                redirect('gallery.php');
            }
        } catch (PDOException $e) {
            set_flash('danger', 'Terjadi kesalahan database: ' . $e->getMessage());
        }
    }
}

require_once 'includes/header.php';

// Get Data for Edit
$edit_item = null;
if ($action == 'edit' && $id) {
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM gallery WHERE id = ?");
    $stmt->execute([$id]);
    $edit_item = $stmt->fetch();
    if (!$edit_item) redirect('gallery.php');
}
?>

<?php if ($action == 'list'): ?>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-images me-2"></i>Daftar Galeri & Produk</span>
            <a href="gallery.php?action=add" class="btn btn-sm btn-primary"><i class="fas fa-plus me-1"></i> Tambah Baru</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="80">Gambar</th>
                            <th>Judul & Deskripsi</th>
                            <th>Kategori</th>
                            <th>Urutan</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $items = get_gallery(null, false); // Get all, include inactive
                        if (empty($items)): ?>
                            <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data</td></tr>
                        <?php else: foreach ($items as $item): ?>
                            <tr>
                                <td><img src="<?= img_url($item['image']) ?>" class="rounded" width="60" height="60" style="object-fit: cover;"></td>
                                <td>
                                    <div class="fw-bold"><?= clean($item['title']) ?></div>
                                    <div class="small text-muted text-truncate" style="max-width: 250px;"><?= clean($item['description']) ?></div>
                                </td>
                                <td>
                                    <?php
                                    $badges = [
                                        'prestasi' => 'warning text-dark',
                                        'produk' => 'info text-dark',
                                        'kegiatan' => 'success'
                                    ];
                                    $badge_class = $badges[$item['category']] ?? 'secondary';
                                    ?>
                                    <span class="badge bg-<?= $badge_class ?>"><?= ucfirst($item['category']) ?></span>
                                </td>
                                <td><?= $item['sort_order'] ?></td>
                                <td>
                                    <?php if ($item['is_active']): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Non-Aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <a href="gallery.php?action=edit&id=<?= $item['id'] ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-edit"></i></a>
                                    <a href="gallery.php?action=delete&id=<?= $item['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus item ini?')"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php elseif ($action == 'add' || $action == 'edit'): ?>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-<?= $action == 'add' ? 'plus' : 'edit' ?> me-2"></i>
                    <?= $action == 'add' ? 'Tambah Item Baru' : 'Edit Item' ?>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul</label>
                            <input type="text" name="title" class="form-control" required value="<?= $edit_item['title'] ?? '' ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Kategori</label>
                            <select name="category" class="form-select" required>
                                <option value="kegiatan" <?= ($edit_item['category'] ?? '') == 'kegiatan' ? 'selected' : '' ?>>Kegiatan</option>
                                <option value="produk" <?= ($edit_item['category'] ?? '') == 'produk' ? 'selected' : '' ?>>Produk Kreatif</option>
                                <option value="prestasi" <?= ($edit_item['category'] ?? '') == 'prestasi' ? 'selected' : '' ?>>Prestasi</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi Singkat</label>
                            <textarea name="description" class="form-control" rows="3"><?= $edit_item['description'] ?? '' ?></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Urutan Tampil</label>
                                <input type="number" name="sort_order" class="form-control" value="<?= $edit_item['sort_order'] ?? 0 ?>">
                                <small class="text-muted">Semakin kecil angka, semakin di depan.</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold d-block">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1" <?= (!isset($edit_item) || $edit_item['is_active']) ? 'checked' : '' ?>>
                                    <label class="form-check-label">Tampilkan di Website</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Upload Gambar</label>
                            <input type="file" name="image" class="form-control" <?= $action == 'add' ? 'required' : '' ?>>
                            <?php if ($action == 'edit' && $edit_item['image']): ?>
                                <div class="mt-2">
                                    <img src="<?= img_url($edit_item['image']) ?>" height="100" class="rounded border">
                                    <small class="text-muted d-block">Gambar saat ini (biarkan kosong jika tidak ingin mengubah)</small>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="gallery.php" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 fw-bold">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
