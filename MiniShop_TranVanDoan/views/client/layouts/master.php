<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle : 'Trang chủ' ?> - 👟 ShoeShop</title>
    <meta name="description" content="ShoeShop - Cửa hàng giày chính hãng cao cấp. Nike, Adidas, Jordan, New Balance, Puma.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1a1a2e;
            --secondary: #16213e;
            --accent: #e94560;
            --accent-hover: #c73a52;
            --gold: #f5a623;
            --light-bg: #f8f9fa;
            --card-shadow: 0 2px 15px rgba(0,0,0,0.08);
        }
        * { font-family: 'Inter', sans-serif; }
        body { background-color: var(--light-bg); }

        /* Navbar */
        .navbar-shop {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 0;
        }
        .navbar-shop .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: #fff !important;
            letter-spacing: -0.5px;
        }
        .navbar-shop .nav-link {
            color: rgba(255,255,255,0.85) !important;
            font-weight: 500;
            padding: 1rem 1rem !important;
            transition: all 0.3s;
            border-bottom: 3px solid transparent;
        }
        .navbar-shop .nav-link:hover,
        .navbar-shop .nav-link.active {
            color: #fff !important;
            border-bottom-color: var(--accent);
        }
        .navbar-shop .dropdown-menu {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            padding: 0.5rem;
        }
        .navbar-shop .dropdown-item {
            border-radius: 8px;
            padding: 0.6rem 1rem;
            transition: all 0.2s;
        }
        .navbar-shop .dropdown-item:hover {
            background: var(--accent);
            color: #fff;
        }

        /* Search bar */
        .search-bar {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 25px;
            overflow: hidden;
        }
        .search-bar input {
            background: transparent;
            border: none;
            color: #fff;
            padding: 0.5rem 1rem;
        }
        .search-bar input::placeholder { color: rgba(255,255,255,0.6); }
        .search-bar input:focus { box-shadow: none; outline: none; }
        .search-bar button {
            background: var(--accent);
            border: none;
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 0 25px 25px 0;
        }
        .search-bar button:hover { background: var(--accent-hover); }

        /* Product Card */
        .product-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            height: 100%;
            border: 1px solid rgba(0,0,0,0.05);
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        }
        .product-card .card-img-top {
            height: 220px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .product-card:hover .card-img-top {
            transform: scale(1.05);
        }
        .product-card .img-wrapper {
            overflow: hidden;
            position: relative;
        }
        .product-card .badge-sale {
            position: absolute;
            top: 10px;
            left: 10px;
            background: var(--accent);
            color: #fff;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            z-index: 2;
        }
        .product-card .card-body {
            padding: 1rem 1.2rem;
        }
        .product-card .product-name {
            font-weight: 600;
            font-size: 0.95rem;
            color: #333;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.4;
            min-height: 2.6em;
        }
        .product-card .product-name a {
            color: inherit;
            text-decoration: none;
        }
        .product-card .product-name a:hover { color: var(--accent); }
        .product-card .product-brand {
            font-size: 0.8rem;
            color: #888;
            margin-bottom: 0.5rem;
        }
        .product-card .price-sale {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--accent);
        }
        .product-card .price-old {
            text-decoration: line-through;
            color: #aaa;
            font-size: 0.85rem;
            margin-left: 6px;
        }

        /* Section */
        .section-title {
            font-weight: 700;
            font-size: 1.6rem;
            color: var(--primary);
            position: relative;
            padding-bottom: 10px;
            margin-bottom: 1.5rem;
        }
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background: var(--accent);
            border-radius: 2px;
        }

        /* Category Card */
        .category-card {
            background: #fff;
            border-radius: 16px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: var(--card-shadow);
            transition: all 0.3s;
            border: 1px solid rgba(0,0,0,0.05);
        }
        .category-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
            border-color: var(--accent);
        }
        .category-card a {
            text-decoration: none;
            color: var(--primary);
            font-weight: 600;
        }
        .category-card i {
            font-size: 2.5rem;
            color: var(--accent);
            margin-bottom: 0.8rem;
            display: block;
        }

        /* Footer */
        .footer-shop {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: rgba(255,255,255,0.8);
            padding: 3rem 0 1.5rem;
        }
        .footer-shop h5 {
            color: #fff;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .footer-shop a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: color 0.2s;
        }
        .footer-shop a:hover { color: var(--accent); }
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 1rem;
            margin-top: 2rem;
        }

        /* Breadcrumb */
        .breadcrumb-shop {
            background: #fff;
            padding: 0.8rem 0;
            border-bottom: 1px solid #eee;
        }

        /* Hero */
        .hero-section {
            background: linear-gradient(135deg, var(--primary) 0%, #0f3460 50%, var(--accent) 100%);
            color: #fff;
            padding: 4rem 0;
            text-align: center;
        }
        .hero-section h1 {
            font-weight: 800;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        .hero-section p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Pagination */
        .pagination .page-link {
            color: var(--primary);
            border-radius: 8px;
            margin: 0 3px;
            border: 1px solid #dee2e6;
        }
        .pagination .page-item.active .page-link {
            background: var(--accent);
            border-color: var(--accent);
        }

        /* Btn */
        .btn-accent {
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 25px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-accent:hover {
            background: var(--accent-hover);
            color: #fff;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<?php include __DIR__ . '/header.php'; ?>

<main style="min-height: 60vh;">
    <?= $content ?? '' ?>
</main>

<?php include __DIR__ . '/footer.php'; ?>

<!-- Toast Container cho thông báo -->
<div id="toastContainer" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1055;"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/client/cart.js"></script>
</body>
</html>
