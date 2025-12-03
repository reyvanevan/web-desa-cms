<?php
$page_title = "Kelola Program Kerja";
require_once 'includes/header.php';

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
    $icon = clean($_POST['icon']);
    $sort_order = (int)$_POST['sort_order'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    try {
        $conn = getConnection();
        if ($action == 'add') {
            $stmt = $conn->prepare("INSERT INTO programs (title, description, icon, sort_order, is_active) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $icon, $sort_order, $is_active]);
            set_flash('success', 'Program berhasil ditambahkan');
            redirect('programs.php');
        } elseif ($action == 'edit' && $id) {
            $stmt = $conn->prepare("UPDATE programs SET title=?, description=?, icon=?, sort_order=?, is_active=? WHERE id=?");
            $stmt->execute([$title, $description, $icon, $sort_order, $is_active, $id]);
            set_flash('success', 'Program berhasil diperbarui');
            redirect('programs.php');
        }
    } catch (PDOException $e) {
        set_flash('danger', 'Terjadi kesalahan database: ' . $e->getMessage());
    }
}

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
                            <th width="60">Icon</th>
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
                                <td class="text-center text-primary fs-4"><i class="<?= clean($item['icon']) ?>"></i></td>
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
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Program</label>
                            <input type="text" name="title" class="form-control" required value="<?= $edit_item['title'] ?? '' ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Icon (FontAwesome Class)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-icons"></i></span>
                                <input type="text" name="icon" class="form-control" placeholder="fas fa-laptop-code" required value="<?= $edit_item['icon'] ?? '' ?>">
                            </div>
                            <div class="form-text">Contoh: <code>fas fa-tree</code>, <code>fas fa-hands-helping</code>. Lihat referensi di <a href="https://fontawesome.com/v5/search?m=free" target="_blank">FontAwesome</a>.</div>
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
