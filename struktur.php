<?php
$page_title = "Struktur Organisasi";
require_once 'includes/header.php';

// Ambil data struktur
$members = get_struktur();
$struktur_desc = get_setting('struktur_description', 'Berikut adalah susunan pengurus KRL CINTA RW 21 Desa Ciangsana.');

// Build Tree
$tree = [];
$refs = [];
foreach ($members as $m) {
    $thisRef = &$refs[$m['id']];
    $thisRef['data'] = $m;
    $thisRef['children'] = [];
    
    if ($m['parent_id'] == 0 || $m['parent_id'] == null) {
        $tree[$m['id']] = &$thisRef;
    } else {
        $refs[$m['parent_id']]['children'][$m['id']] = &$thisRef;
    }
}

// Recursive function to render tree with UL/LI structure
function render_tree($nodes) {
    if (empty($nodes)) return;
    
    echo '<ul>';
    foreach ($nodes as $node) {
        $member = $node['data'];
        echo '<li>';
        
        // Card Content
        echo '<div class="org-card">';
        echo '<div class="img-box">';
        echo '<img src="' . img_url($member['foto']) . '" alt="' . clean($member['nama']) . '">';
        echo '</div>';
        echo '<div class="info-box">';
        echo '<h6 class="fw-bold mb-0 text-dark">' . clean($member['nama']) . '</h6>';
        echo '<small class="text-primary fw-bold text-uppercase" style="font-size: 0.7rem;">' . clean($member['jabatan']) . '</small>';
        echo '</div>';
        echo '</div>';
        
        // Children
        if (!empty($node['children'])) {
            render_tree($node['children']);
        }
        
        echo '</li>';
    }
    echo '</ul>';
}
?>

<style>
    /* CSS Tree Diagram */
    .org-tree {
        display: flex;
        justify-content: center;
        overflow-x: auto;
        padding: 20px 0;
    }

    .tree ul {
        padding-top: 20px; 
        position: relative;
        transition: all 0.5s;
        display: flex;
        justify-content: center;
        margin: 0;
        padding-left: 0;
    }

    .tree li {
        float: left; text-align: center;
        list-style-type: none;
        position: relative;
        padding: 20px 10px 0 10px;
        transition: all 0.5s;
    }

    /* Connectors */
    .tree li::before, .tree li::after {
        content: '';
        position: absolute; top: 0; right: 50%;
        border-top: 2px solid #ccc;
        width: 50%; height: 20px;
    }
    .tree li::after {
        right: auto; left: 50%;
        border-left: 2px solid #ccc;
    }

    /* Remove connectors from single children */
    .tree li:only-child::after, .tree li:only-child::before {
        display: none;
    }
    .tree li:only-child { padding-top: 0; }

    /* Remove left connector from first child and right from last */
    .tree li:first-child::before, .tree li:last-child::after {
        border: 0 none;
    }
    
    /* Add vertical connector back to last nodes */
    .tree li:last-child::before {
        border-right: 2px solid #ccc;
        border-radius: 0 5px 0 0;
    }
    .tree li:first-child::after {
        border-radius: 5px 0 0 0;
    }

    /* Downward connectors from parents */
    .tree ul ul::before {
        content: '';
        position: absolute; top: 0; left: 50%;
        border-left: 2px solid #ccc;
        width: 0; height: 20px;
    }

    /* Card Styling */
    .org-card {
        background: var(--bg-card);
        border: 1px solid rgba(0,0,0,0.1);
        padding: 15px;
        border-radius: 12px;
        display: inline-block;
        min-width: 180px;
        max-width: 220px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        transition: all 0.3s;
        position: relative;
        z-index: 2;
    }
    
    .org-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px rgba(0,0,0,0.1);
        border-color: var(--primary);
    }

    .org-card .img-box img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--bg-body);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        margin-bottom: 10px;
    }
    
    /* Dark Mode Adjustments */
    body.dark-mode .tree li::before, 
    body.dark-mode .tree li::after, 
    body.dark-mode .tree ul ul::before {
        border-color: #555;
    }
    body.dark-mode .org-card .info-box h6 {
        color: #e8eaed !important;
    }
</style>

    <header class="page-header" style="background-image: linear-gradient(rgba(0, 105, 92, 0.9), rgba(0, 77, 64, 0.9)), url('<?= img_url(get_setting('struktur_bg', 'https://placehold.co/1920x600?text=Struktur+Organisasi')) ?>');">
        <div class="container" data-aos="fade-up">
            <h1>Struktur Organisasi</h1>
            <p class="lead opacity-75">Susunan pengurus yang berdedikasi untuk kemajuan lingkungan.</p>
        </div>
    </header>

    <section class="mb-5">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center" data-aos="fade-up">
                    <h3 class="fw-bold mb-4 text-primary"><i class="fas fa-users me-2"></i>Susunan Pengurus</h3>
                    <p class="text-muted"><?= nl2br(clean($struktur_desc)) ?></p>
                </div>
            </div>

            <?php if (empty($members)): ?>
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i> Belum ada data pengurus yang ditambahkan.
                </div>
            <?php else: ?>
                <div class="org-tree-container overflow-auto pb-5" data-aos="fade-up">
                    <div class="tree org-tree">
                        <?php render_tree($tree); ?>
                    </div>
                </div>
                
                <!-- Mobile List View (Visible only on very small screens if tree is too wide) -->
                <div class="d-block d-md-none mt-4 text-center">
                    <small class="text-muted"><i class="fas fa-arrows-alt-h me-1"></i> Geser ke samping untuk melihat struktur lengkap</small>
                </div>
            <?php endif; ?>
        </div>
    </section>

<?php require_once 'includes/footer.php'; ?>
