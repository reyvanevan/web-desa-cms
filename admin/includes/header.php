<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

if (!is_logged_in()) {
    redirect('login.php');
}

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - KRL CINTA</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #00695c;
            --secondary: #4db6ac;
            --bg-body: #F8F9FA;
            --bg-card: #FFFFFF;
            --text-main: #202124;
            --text-muted: #5f6368;
            --border-color: #e0e0e0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            color: var(--text-main);
        }

        /* --- SIDEBAR --- */
        .sidebar {
            min-height: 100vh;
            width: 250px;
            background: var(--bg-card);
            position: fixed;
            top: 0;
            left: 0;
            border-right: 1px solid var(--border-color);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-brand {
            height: 70px;
            display: flex;
            align-items: center;
            padding: 0 20px;
            font-weight: 700;
            color: var(--primary);
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-menu {
            padding: 20px 10px;
        }

        .nav-link {
            color: var(--text-muted);
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 5px;
            font-weight: 500;
            transition: 0.3s;
        }

        .nav-link:hover,
        .nav-link.active {
            background-color: rgba(0, 105, 92, 0.1);
            color: var(--primary);
        }

        .nav-link i {
            width: 25px;
        }

        /* --- MAIN CONTENT --- */
        .main-content {
            margin-left: 250px;
            padding: 30px;
            transition: margin-left 0.3s ease;
        }

        /* --- CARDS --- */
        .card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border-color);
            padding: 20px;
            font-weight: 700;
            color: var(--text-main);
        }

        .form-control, .form-select {
            background-color: var(--bg-body);
            border: 1px solid var(--border-color);
            color: var(--text-main);
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(0, 105, 92, 0.25);
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0; left: 0; width: 100%; height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
            }
            .sidebar.show ~ .sidebar-overlay { display: block; }
        }
    </style>
</head>

<body>

    <!-- Overlay for mobile sidebar -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <div class="sidebar d-flex flex-column" id="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-leaf me-2"></i> ADMIN PANEL
        </div>
        <ul class="nav flex-column sidebar-menu">
            <li class="nav-item">
                <a class="nav-link <?= $current_page == 'index.php' ? 'active' : '' ?>" href="index.php"><i class="fas fa-home"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $current_page == 'settings.php' ? 'active' : '' ?>" href="settings.php"><i class="fas fa-cog"></i> Pengaturan Umum</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $current_page == 'gallery.php' ? 'active' : '' ?>" href="gallery.php"><i class="fas fa-images"></i> Galeri & Produk</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $current_page == 'programs.php' ? 'active' : '' ?>" href="programs.php"><i class="fas fa-tasks"></i> Program Unggulan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $current_page == 'misi.php' ? 'active' : '' ?>" href="misi.php"><i class="fas fa-list-ul"></i> Visi & Misi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $current_page == 'struktur.php' ? 'active' : '' ?>" href="struktur.php"><i class="fas fa-sitemap"></i> Struktur Organisasi</a>
            </li>
            <li class="nav-item mt-4">
                <a class="nav-link text-danger" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <button class="btn btn-outline-secondary d-md-none me-3" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
                <h2 class="fw-bold mb-0"><?= isset($page_title) ? $page_title : 'Dashboard' ?></h2>
            </div>
            <div class="text-muted small">
                Halo, <strong><?= $_SESSION['admin_name'] ?? 'Admin' ?></strong>
            </div>
        </div>

        <?php if ($flash = get_flash()): ?>
            <div class="alert alert-<?= $flash['type'] ?> alert-dismissible fade show" role="alert">
                <?= $flash['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
