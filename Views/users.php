<?php
$pageTitle = 'کاربران';
$bodyClass = 'bg-body-tertiary';
$showNavbar = true;
require __DIR__ . '/partials/head.php';
?>

<main class="container py-4 py-lg-5">
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">کاربران</h1>
        <p class="text-body-secondary mb-0">لیست کاربران سیستم.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-5 text-center">
            <div class="empty-state-icon bg-success-subtle text-success mb-3">
                <i class="bi bi-people"></i>
            </div>
            <h2 class="h5 fw-bold mb-2">هنوز کاربری نمایش داده نشده است</h2>
            <p class="text-body-secondary small mb-4">کاربران ثبت‌شده در این بخش نمایش داده می‌شوند.</p>
            <a href="/home" class="btn btn-outline-primary">
                <i class="bi bi-arrow-right ms-1"></i>
                بازگشت به داشبورد
            </a>
        </div>
    </div>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>