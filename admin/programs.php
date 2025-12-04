<?php
$page_title = "Kelola Program Kerja";
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
        $conn->prepare("DELETE FROM programs WHERE id = ?")->execute([$id]);
        set_flash('success', 'Program berhasil dihapus');
    } catch (PDOException $e) {
        set_flash('danger', 'Gagal menghapus program');
    }
    redirect('programs.php');
}

// Handle Form Submit (Add/Edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = clean($_POST['title']);
    $description = clean($_POST['description']);
    $sort_order = (int)$_POST['sort_order'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    // Handle Image Upload
    $image_path = $edit_item['image'] ?? ''; // Keep old image by default
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload = upload_image($_FILES['image'], 'programs');
        if ($upload['success']) {
            $image_path = $upload['path'];
            // Delete old image if exists
            if (!empty($edit_item['image'])) {
                delete_image($edit_item['image']);
            }
        } else {
            set_flash('warning', 'Gagal upload gambar: ' . $upload['message']);
        }
    }

    try {
        $conn = getConnection();
        if ($action == 'add') {
            $stmt = $conn->prepare("INSERT INTO programs (title, description, image, sort_order, is_active) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $image_path, $sort_order, $is_active]);
            set_flash('success', 'Program berhasil ditambahkan');
            redirect('programs.php');
        } elseif ($action == 'edit' && $id) {
            $stmt = $conn->prepare("UPDATE programs SET title=?, description=?, image=?, sort_order=?, is_active=? WHERE id=?");
            $stmt->execute([$title, $description, $image_path, $sort_order, $is_active, $id]);
            set_flash('success', 'Program berhasil diperbarui');
            redirect('programs.php');
        }
    } catch (PDOException $e) {
        set_flash('danger', 'Terjadi kesalahan database: ' . $e->getMessage());
    }
}

require_once 'includes/header.php';

// Get Data for Edit
$edit_item = null;
if ($action == 'edit' && $id) {
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM programs WHERE id = ?");
    $stmt->execute([$id]);
    $edit_item = $stmt->fetch();
    if (!$edit_item) redirect('programs.php');
}
?>

<?php if ($action == 'list'): ?>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-tasks me-2"></i>Daftar Program Kerja</span>
            <a href="programs.php?action=add" class="btn btn-sm btn-primary"><i class="fas fa-plus me-1"></i> Tambah Baru</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="100">Gambar</th>
                            <th>Nama Program</th>
                            <th>Deskripsi</th>
                            <th>Urutan</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $items = get_programs(false); // Get all, include inactive
                        if (empty($items)): ?>
                            <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data</td></tr>
                        <?php else: foreach ($items as $item): ?>
                            <tr>
                                <td class="text-center">
                                    <img src="<?= img_url($item['image']) ?>" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                </td>
                                <td class="fw-bold"><?= clean($item['title']) ?></td>
                                <td class="text-muted small"><?= clean($item['description']) ?></td>
                                <td><?= $item['sort_order'] ?></td>
                                <td>
                                    <?php if ($item['is_active']): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Non-Aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <a href="programs.php?action=edit&id=<?= $item['id'] ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-edit"></i></a>
                                    <a href="programs.php?action=delete&id=<?= $item['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus program ini?')"><i class="fas fa-trash"></i></a>
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
                    <?= $action == 'add' ? 'Tambah Program Baru' : 'Edit Program' ?>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Program</label>
                            <input type="text" name="title" class="form-control" required value="<?= $edit_item['title'] ?? '' ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Gambar Program</label>
                            <input type="file" name="image" class="form-control">
                            <?php if (!empty($edit_item['image'])): ?>
                                <div class="mt-2">
                                    <img src="<?= img_url($edit_item['image']) ?>" height="100" class="rounded">
                                    <small class="text-muted ms-2">Gambar saat ini</small>
                                </div>
                            <?php endif; ?>
                            <div class="form-text small">Format: JPG, PNG, WEBP. Max 2MB.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi Singkat</label>
                            <textarea name="description" class="form-control" rows="3" required><?= $edit_item['description'] ?? '' ?></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Urutan Tampil</label>
                                <input type="number" name="sort_order" class="form-control" value="<?= $edit_item['sort_order'] ?? 0 ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold d-block">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1" <?= (!isset($edit_item) || $edit_item['is_active']) ? 'checked' : '' ?>>
                                    <label class="form-check-label">Tampilkan di Website</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="programs.php" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 fw-bold">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
