<?php
$page_title = "Kelola Struktur Organisasi";
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
        // Get image path first
        $stmt = $conn->prepare("SELECT foto FROM struktur_organisasi WHERE id = ?");
        $stmt->execute([$id]);
        $item = $stmt->fetch();
        
        if ($item) {
            if ($item['foto']) delete_image($item['foto']);
            $conn->prepare("DELETE FROM struktur_organisasi WHERE id = ?")->execute([$id]);
            set_flash('success', 'Anggota berhasil dihapus');
        }
    } catch (PDOException $e) {
        set_flash('danger', 'Gagal menghapus anggota');
    }
    redirect('struktur.php');
}

// Handle Form Submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = clean($_POST['nama']);
    $jabatan = clean($_POST['jabatan']);
    $parent_id = !empty($_POST['parent_id']) ? (int)$_POST['parent_id'] : null;
    $sort_order = (int)$_POST['sort_order'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    $foto_path = '';
    
    // Handle Image Upload
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $upload = upload_image($_FILES['foto'], 'struktur');
        if ($upload['success']) {
            $foto_path = $upload['path'];
        } else {
            set_flash('warning', 'Gagal upload foto: ' . $upload['message']);
        }
    }

    try {
        $conn = getConnection();
        if ($action == 'add') {
            $stmt = $conn->prepare("INSERT INTO struktur_organisasi (nama, jabatan, parent_id, foto, sort_order, is_active) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nama, $jabatan, $parent_id, $foto_path, $sort_order, $is_active]);
            set_flash('success', 'Anggota berhasil ditambahkan');
            redirect('struktur.php');
        } elseif ($action == 'edit' && $id) {
            $sql = "UPDATE struktur_organisasi SET nama=?, jabatan=?, parent_id=?, sort_order=?, is_active=?";
            $params = [$nama, $jabatan, $parent_id, $sort_order, $is_active];
            
            if ($foto_path) {
                $sql .= ", foto=?";
                $params[] = $foto_path;
                
                // Delete old photo
                $stmt = $conn->prepare("SELECT foto FROM struktur_organisasi WHERE id = ?");
                $stmt->execute([$id]);
                $old = $stmt->fetch();
                if ($old && $old['foto']) delete_image($old['foto']);
            }
            
            $sql .= " WHERE id=?";
            $params[] = $id;
            
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
            set_flash('success', 'Data anggota berhasil diperbarui');
            redirect('struktur.php');
        }
    } catch (PDOException $e) {
        set_flash('danger', 'Terjadi kesalahan database: ' . $e->getMessage());
    }
}

require_once 'includes/header.php';

// Get Data for Edit
$edit_item = null;
$all_members = [];
if ($action == 'add' || $action == 'edit') {
    $conn = getConnection();
    // Get all members for parent selection
    $stmt = $conn->query("SELECT id, nama, jabatan FROM struktur_organisasi ORDER BY sort_order ASC");
    $all_members = $stmt->fetchAll();
}

if ($action == 'edit' && $id) {
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM struktur_organisasi WHERE id = ?");
    $stmt->execute([$id]);
    $edit_item = $stmt->fetch();
    if (!$edit_item) redirect('struktur.php');
}
?>

<?php if ($action == 'list'): ?>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-sitemap me-2"></i>Daftar Pengurus Organisasi</span>
            <a href="struktur.php?action=add" class="btn btn-sm btn-primary"><i class="fas fa-plus me-1"></i> Tambah Anggota</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="80">Foto</th>
                            <th>Nama Lengkap</th>
                            <th>Jabatan</th>
                            <th>Urutan</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $items = get_struktur(false); 
                        if (empty($items)): ?>
                            <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data pengurus</td></tr>
                        <?php else: foreach ($items as $item): ?>
                            <tr>
                                <td>
                                    <?php if ($item['foto']): ?>
                                        <img src="<?= img_url($item['foto']) ?>" class="rounded-circle" width="50" height="50" style="object-fit: cover;">
                                    <?php else: ?>
                                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white" style="width: 50px; height: 50px;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="fw-bold"><?= clean($item['nama']) ?></td>
                                <td><span class="badge bg-info text-dark"><?= clean($item['jabatan']) ?></span></td>
                                <td><?= $item['sort_order'] ?></td>
                                <td>
                                    <?php if ($item['is_active']): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Non-Aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <a href="struktur.php?action=edit&id=<?= $item['id'] ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-edit"></i></a>
                                    <a href="struktur.php?action=delete&id=<?= $item['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus anggota ini?')"><i class="fas fa-trash"></i></a>
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
                    <?= $action == 'add' ? 'Tambah Anggota Baru' : 'Edit Data Anggota' ?>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" required value="<?= $edit_item['nama'] ?? '' ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" required value="<?= $edit_item['jabatan'] ?? '' ?>" placeholder="Contoh: Ketua, Sekretaris, Anggota" list="jabatanOptions">
                            <datalist id="jabatanOptions">
                                <option value="Penanggung Jawab">
                                <option value="Penasehat">
                                <option value="Pembimbing">
                                <option value="Pelindung">
                                <option value="Pembina">
                                <option value="Ketua">
                                <option value="Sekretaris">
                                <option value="Bendahara">
                                <option value="Sie LHK">
                                <option value="Sie Pencatatan">
                                <option value="Sie Humas">
                                <option value="Sie Penimbangan">
                                <option value="Sie Logistik">
                            </datalist>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Atasan (Parent)</label>
                            <select name="parent_id" class="form-select">
                                <option value="">-- Tidak Ada (Top Level) --</option>
                                <?php foreach ($all_members as $m): ?>
                                    <?php if ($action == 'edit' && $m['id'] == $id) continue; // Skip self ?>
                                    <option value="<?= $m['id'] ?>" <?= (isset($edit_item) && $edit_item['parent_id'] == $m['id']) ? 'selected' : '' ?>>
                                        <?= clean($m['nama']) ?> (<?= clean($m['jabatan']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted">Pilih atasan untuk membuat struktur hierarki.</small>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Urutan Tampil</label>
                                <input type="number" name="sort_order" class="form-control" value="<?= $edit_item['sort_order'] ?? 0 ?>">
                                <small class="text-muted">1 untuk Ketua (Paling Atas)</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold d-block">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1" <?= (!isset($edit_item) || $edit_item['is_active']) ? 'checked' : '' ?>>
                                    <label class="form-check-label">Tampilkan</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Foto Profil (Opsional)</label>
                            <input type="file" name="foto" class="form-control">
                            <?php if ($action == 'edit' && !empty($edit_item['foto'])): ?>
                                <div class="mt-2">
                                    <img src="<?= img_url($edit_item['foto']) ?>" height="100" class="rounded-circle border">
                                    <small class="text-muted d-block">Foto saat ini</small>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="struktur.php" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 fw-bold">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
