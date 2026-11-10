<?php
$pageTitle = 'داشبورد';
$bodyClass = 'bg-body-tertiary';
$showNavbar = true;
require __DIR__ . '/partials/head.php';
?>

<main class="container py-4 py-lg-5">
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">داشبورد</h1>
        <p class="text-body-secondary mb-0">به سیستم مدیریت انبار خوش آمدید.</p>
    </div>

    <div class="row g-4">
        <div class="col-12 col-md-6 col-xl-4">
            <a href="/products" class="text-decoration-none">
                <div class="card quick-card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="icon-box bg-primary-subtle text-primary mb-3">
                            <i class="bi bi-box-seam fs-4"></i>
                        </div>
                        <h2 class="h5 fw-bold text-body mb-2">مدیریت محصولات</h2>
                        <p class="text-body-secondary small mb-0">مشاهده و مدیریت اقلام موجود در انبار.</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <a href="/users" class="text-decoration-none">
                <div class="card quick-card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="icon-box bg-success-subtle text-success mb-3">
                            <i class="bi bi-people fs-4"></i>
                        </div>
                        <h2 class="h5 fw-bold text-body mb-2">مدیریت کاربران</h2>
                        <p class="text-body-secondary small mb-0">مشاهده کاربران و دسترسی‌های آن‌ها.</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>