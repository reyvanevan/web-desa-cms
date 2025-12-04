<?php
$page_title = "Kelola Misi";
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
        $conn->prepare("DELETE FROM misi WHERE id = ?")->execute([$id]);
        set_flash('success', 'Misi berhasil dihapus');
    } catch (PDOException $e) {
        set_flash('danger', 'Gagal menghapus misi');
    }
    redirect('misi.php');
}

// Handle Form Submit (Add/Edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = clean($_POST['content']);
    $sort_order = (int)$_POST['sort_order'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    try {
        $conn = getConnection();
        if ($action == 'add') {
            $stmt = $conn->prepare("INSERT INTO misi (content, sort_order, is_active) VALUES (?, ?, ?)");
            $stmt->execute([$content, $sort_order, $is_active]);
            set_flash('success', 'Misi berhasil ditambahkan');
            redirect('misi.php');
        } elseif ($action == 'edit' && $id) {
            $stmt = $conn->prepare("UPDATE misi SET content=?, sort_order=?, is_active=? WHERE id=?");
            $stmt->execute([$content, $sort_order, $is_active, $id]);
            set_flash('success', 'Misi berhasil diperbarui');
            redirect('misi.php');
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
    $stmt = $conn->prepare("SELECT * FROM misi WHERE id = ?");
    $stmt->execute([$id]);
    $edit_item = $stmt->fetch();
    if (!$edit_item) redirect('misi.php');
}
?>

<?php if ($action == 'list'): ?>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-list-ol me-2"></i>Daftar Misi</span>
            <a href="misi.php?action=add" class="btn btn-sm btn-primary"><i class="fas fa-plus me-1"></i> Tambah Baru</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="50">#</th>
                            <th>Isi Misi</th>
                            <th>Urutan</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $items = get_misi(false); // Get all, include inactive
                        if (empty($items)): ?>
                            <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada data</td></tr>
                        <?php else: foreach ($items as $index => $item): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= clean($item['content']) ?></td>
                                <td><?= $item['sort_order'] ?></td>
                                <td>
                                    <?php if ($item['is_active']): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Non-Aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <a href="misi.php?action=edit&id=<?= $item['id'] ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-edit"></i></a>
                                    <a href="misi.php?action=delete&id=<?= $item['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus misi ini?')"><i class="fas fa-trash"></i></a>
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
                    <?= $action == 'add' ? 'Tambah Misi Baru' : 'Edit Misi' ?>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Isi Misi</label>
                            <textarea name="content" class="form-control" rows="3" required><?= $edit_item['content'] ?? '' ?></textarea>
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
                            <a href="misi.php" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 fw-bold">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
