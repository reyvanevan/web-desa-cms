<?php
require_once __DIR__ . '/functions.php';
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title . ' - ' : '' ?>KRL CINTA - Web Hasil KKN</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            /* --- GOOGLE STYLE PALETTE (Light Mode) --- */
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
            overflow-x: hidden;
            background-color: var(--bg-body);
            color: var(--text-main);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        h1, h2, h3, h4, h5 {
            font-family: 'Playfair Display', serif;
            color: var(--text-main);
        }

        /* --- NAVBAR GLASSMORPHISM --- */
        .navbar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            padding: 15px 0;
        }

        .nav-link {
            font-weight: 500;
            color: var(--text-main) !important;
            margin: 0 10px;
        }
        
        .nav-link.active {
            color: var(--primary) !important;
            font-weight: 700;
        }

        /* --- DROPDOWN GLASSMORPHISM --- */
        .dropdown-menu {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 10px;
            margin-top: 10px;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 8px 16px;
            font-weight: 500;
            color: var(--text-main);
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background-color: rgba(0, 105, 92, 0.1);
            color: var(--primary);
            padding-left: 25px;
        }
        
        .dropdown-header {
            color: var(--text-muted);
            font-weight: 700;
            font-size: 0.8rem;
        }

        /* --- HERO SECTION --- */
        .hero {
            position: relative;
            min-height: 85vh;
            height: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            overflow: visible;
            padding-top: 120px;
            padding-bottom: 120px;
        }

        .hero h1 {
            color: #ffffff;
            font-size: 4rem;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            background-attachment: fixed;
            z-index: -2;
            filter: brightness(0.6);
        }

        /* --- CARDS & STATS --- */
        .stats-box, .card-program {
            background-color: var(--bg-card);
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border-radius: 16px;
            color: var(--text-main);
        }

        .stats-box {
            padding: 40px;
            margin-top: -80px;
            position: relative;
            z-index: 10;
        }

        .hero-subtitle {
            letter-spacing: 3px;
            font-size: 0.9rem;
        }

        .card-program {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
        }

        .card-program:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .card-img-wrapper {
            overflow: hidden;
            height: 250px;
        }

        .card-program img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.5s;
        }

        .card-program:hover img {
            transform: scale(1.05);
        }

        /* --- GALLERY --- */
        .gallery-img {
            border-radius: 16px;
            width: 100%;
            height: 250px;
            object-fit: cover;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        /* Gallery Grid Items (from galeri.html) */
        .gallery-card {
            background-color: var(--bg-card);
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            height: 100%;
        }

        .gallery-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .gallery-img-wrapper {
            height: 250px;
            overflow: hidden;
            position: relative;
        }

        .gallery-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .gallery-card:hover img {
            transform: scale(1.1);
        }
        
        .gallery-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            color: white;
            padding: 4px 10px;
            border-radius: 50px;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        .gallery-body {
            padding: 20px;
        }

        /* --- BUTTONS --- */
        .btn-glow {
            background: #00695c;
            color: white;
            padding: 12px 32px;
            border-radius: 100px;
            font-weight: 500;
            box-shadow: 0 4px 10px rgba(0, 105, 92, 0.3);
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-glow:hover {
            background: #004d40;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 105, 92, 0.4);
            color: white;
        }
        
        /* --- PAGE HEADER (Sub-page Style) --- */
        .page-header {
            position: relative;
            background-size: cover;
            background-position: center;
            padding: 160px 0 80px;
            color: white;
            text-align: center;
            margin-bottom: 60px;
            z-index: 1;
        }
        
        .page-header::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: -1;
        }

        .page-header h1 {
            color: white;
            font-size: 3.5rem;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
        }
        
        /* --- CONTENT CARDS --- */
        .content-card {
            background: var(--bg-card);
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .vision-box {
            background: rgba(0, 105, 92, 0.05);
            border-left: 5px solid var(--primary);
            padding: 30px;
            border-radius: 8px;
            margin: 20px 0;
        }

        /* --- FOOTER --- */
        footer {
            background-color: var(--text-main);
            color: #bdc1c6;
            padding: 60px 0 20px;
        }

        footer a {
            color: #e8eaed;
            text-decoration: none;
        }

        footer a:hover {
            color: var(--secondary);
        }

        /* --- MOBILE RESPONSIVE --- */
        @media (max-width: 768px) {
            .navbar-brand { font-size: 1.2rem; }
            .hero { min-height: auto; height: auto; padding-top: 140px; padding-bottom: 60px; }
            .hero-bg { background-attachment: scroll; background-position: center top; }
            .hero h1 { font-size: 2.2rem; }
            .hero-subtitle { letter-spacing: 1px; font-size: 0.75rem; }
            .stats-box { margin-top: 0 !important; margin-bottom: 40px; padding: 25px; margin-left: 15px; margin-right: 15px; }
            .border-end { border-right: none !important; border-bottom: 1px solid #eee; padding-bottom: 20px; margin-bottom: 20px; }
            .col-md-4:last-child .border-end { border-bottom: none; padding-bottom: 0; margin-bottom: 0; }
            .col-md-4:last-child { border-bottom: none !important; }
        }

        /* --- DARK MODE CONFIGURATION --- */
        body.dark-mode {
            --bg-body: #202124;
            --bg-card: #303134;
            --text-main: #E8EAED;
            --text-muted: #9AA0A6;
            --border-color: #3c4043;
        }

        body.dark-mode .navbar { background: rgba(32, 33, 36, 0.9); border-bottom: 1px solid rgba(255, 255, 255, 0.08); }
        body.dark-mode .navbar-brand { color: #E8EAED !important; }
        body.dark-mode .navbar-toggler-icon { filter: invert(1) grayscale(100%) brightness(200%); }
        body.dark-mode footer { background-color: #171717; border-top: 1px solid rgba(255, 255, 255, 0.1); }
        body.dark-mode footer h4, body.dark-mode footer h5, body.dark-mode footer .text-white { color: #E8EAED !important; }
        body.dark-mode footer a { color: #9AA0A6; }
        body.dark-mode footer a:hover { color: #80cbc4; }
        body.dark-mode .dropdown-menu { background: rgba(32, 33, 36, 0.95); border: 1px solid rgba(255, 255, 255, 0.05); }
        body.dark-mode .dropdown-item { color: #E8EAED; }
        body.dark-mode .dropdown-item:hover { background-color: rgba(255, 255, 255, 0.1); color: #80cbc4; }
        body.dark-mode .dropdown-header { color: #80cbc4 !important; }
        body.dark-mode .dropdown-divider { border-color: rgba(255, 255, 255, 0.1); }
        body.dark-mode .bg-light { background-color: #202124 !important; }
        body.dark-mode .card-program, body.dark-mode .stats-box, body.dark-mode .gallery-card, body.dark-mode .content-card { background-color: var(--bg-card); border: 1px solid rgba(255, 255, 255, 0.05); box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3); }
        body.dark-mode h1, body.dark-mode h2, body.dark-mode h3, body.dark-mode h4 { color: var(--text-main); }
        body.dark-mode .text-muted { color: var(--text-muted) !important; }
        body.dark-mode .text-primary { color: #80cbc4 !important; }
        body.dark-mode #darkModeToggle { color: #FDB813; background: rgba(255, 255, 255, 0.05); }
        body.dark-mode .border-end { border-color: rgba(255, 255, 255, 0.1) !important; }
        body.dark-mode .btn-outline-dark { color: #E8EAED; border-color: #E8EAED; }
        body.dark-mode .btn-outline-dark:hover { background-color: #E8EAED; color: var(--bg-body); }
        body.dark-mode .list-group-item { color: var(--text-main) !important; border-color: rgba(255, 255, 255, 0.1); }
        body.dark-mode .alert-light { background-color: #303134; color: #E8EAED; border-color: rgba(255, 255, 255, 0.1); }
        
        /* Nav Pills Dark Mode */
        body.dark-mode .nav-pills .nav-link { color: #E8EAED !important; background: rgba(255, 255, 255, 0.05); border-color: rgba(255, 255, 255, 0.1); }
        body.dark-mode .nav-pills .nav-link:hover { background: rgba(255, 255, 255, 0.1); }
        body.dark-mode .nav-pills .nav-link.active { background: var(--primary) !important; color: white !important; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5); }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php" style="color: var(--primary); font-size: 1.5rem;">
                <i class="fas fa-leaf me-2"></i>KRL CINTA
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">

                    <li class="nav-item"><a class="nav-link <?= $current_page == 'index.php' ? 'active' : '' ?>" href="index.php">Beranda</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?= $current_page == 'sejarah.php' ? 'active' : '' ?>" href="#" id="navbarDropdown1" role="button" data-bs-toggle="dropdown">
                            Tentang
                        </a>
                        <ul class="dropdown-menu shadow-sm border-0">
                            <li><a class="dropdown-item" href="sejarah.php">Sejarah & Visi Misi</a></li>
                            <li><a class="dropdown-item" href="struktur.php">Struktur Organisasi</a></li>
                            <li><a class="dropdown-item" href="index.php#about">Legalitas & SK</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-bs-toggle="dropdown">
                            Program
                        </a>
                        <ul class="dropdown-menu shadow-sm border-0">
                            <li><a class="dropdown-item" href="index.php#kegiatan">Bank Sampah Induk</a></li>
                            <li><a class="dropdown-item" href="index.php#kegiatan">Sedekah Sampah</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><h6 class="dropdown-header text-primary">Inovasi Organik</h6></li>
                            <li><a class="dropdown-item" href="index.php#kegiatan">Eco-Enzyme</a></li>
                            <li><a class="dropdown-item" href="index.php#kegiatan">Budikdamber & Biopori</a></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="index.php#produk">Produk</a></li>

                    <li class="nav-item"><a class="nav-link text-success <?= $current_page == 'galeri.php' ? 'active' : '' ?>" href="galeri.php">Galeri & Prestasi</a></li>

                    <li class="nav-item"><a class="nav-link" href="index.php#kontak">Kontak</a></li>

                    <li class="nav-item ms-lg-3">
                        <button id="darkModeToggle" class="btn btn-outline-dark rounded-circle border-0">
                            <i class="fas fa-moon"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
