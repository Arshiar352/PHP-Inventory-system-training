<?php
$pageTitle = $pageTitle ?? 'سیستم مدیریت انبار';
$bodyClass = $bodyClass ?? 'bg-body-tertiary';
$showNavbar = $showNavbar ?? false;
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '/';

$navItems = [
    '/home' => ['label' => 'داشبورد', 'icon' => 'bi-speedometer2'],
    '/products' => ['label' => 'محصولات', 'icon' => 'bi-box-seam'],
    '/users' => ['label' => 'کاربران', 'icon' => 'bi-people'],
];
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($pageTitle) ?> | سیستم مدیریت انبار</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --app-font: 'Vazirmatn', Tahoma, sans-serif;
        }

        body {
            font-family: var(--app-font);
        }

        /* Navbar */
        .app-navbar {
            background: linear-gradient(135deg, #0b3d91 0%, #0d6efd 100%);
        }

        .app-navbar .nav-link {
            border-radius: .5rem;
            padding-inline: .85rem;
            transition: background-color .15s ease;
        }

        .app-navbar .nav-link:hover {
            background-color: rgba(255, 255, 255, .12);
        }

        .app-navbar .nav-link.active {
            background-color: rgba(255, 255, 255, .2);
            font-weight: 600;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2rem;
            height: 2rem;
            border-radius: .6rem;
            background: rgba(255, 255, 255, .18);
        }

        /* Auth pages */
        .auth-page {
            min-height: 100vh;
            background: linear-gradient(135deg, #0b3d91 0%, #0d6efd 55%, #6f42c1 100%);
        }

        .auth-card {
            border: 0;
            border-radius: 1.25rem;
            box-shadow: 0 1.5rem 3rem rgba(3, 22, 63, .35);
            overflow: hidden;
        }

        .auth-brand-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 1rem;
            background: rgba(13, 110, 253, .1);
            color: #0d6efd;
            font-size: 1.5rem;
        }

        .auth-page .input-group-text {
            background: #f8f9fa;
            color: #6c757d;
        }

        /* Dashboard cards */
        .icon-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
            border-radius: .85rem;
        }

        .quick-card {
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .quick-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 .75rem 1.5rem rgba(13, 110, 253, .15) !important;
        }

        /* Empty states */
        .empty-state-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 4.5rem;
            height: 4.5rem;
            border-radius: 1.25rem;
            font-size: 1.75rem;
        }
    </style>
</head>
<body class="<?= htmlspecialchars($bodyClass) ?>">
<?php if ($showNavbar): ?>
    <nav class="navbar navbar-expand-lg navbar-dark app-navbar shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="/home">
                <span class="brand-badge"><i class="bi bi-box-seam"></i></span>
                <span>مدیریت انبار</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                    aria-controls="mainNavbar" aria-expanded="false" aria-label="باز و بسته کردن منو">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php foreach ($navItems as $itemPath => $item): ?>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-2 <?= $currentPath === $itemPath ? 'active' : '' ?>"
                               href="<?= $itemPath ?>"
                               <?= $currentPath === $itemPath ? 'aria-current="page"' : '' ?>>
                                <i class="bi <?= $item['icon'] ?>"></i>
                                <?= $item['label'] ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <a href="/logout" class="btn btn-outline-light btn-sm d-flex align-items-center gap-2">
                    <i class="bi bi-box-arrow-left"></i>
                    خروج
                </a>
            </div>
        </div>
    </nav>
<?php endif; ?>
