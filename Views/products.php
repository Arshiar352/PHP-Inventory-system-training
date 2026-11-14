<?php
$pageTitle = 'محصولات';
$bodyClass = 'bg-body-tertiary';
$showNavbar = true;

require __DIR__ . '/partials/head.php';
?>

<main class="container py-4 py-lg-5">

    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">محصولات</h1>
        <p class="text-body-secondary mb-0">
            لیست محصولات ثبت‌شده در انبار.
        </p>
    </div>

    <?php if (empty($products)): ?>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-5 text-center">
                <i class="bi bi-box-seam fs-1 text-primary"></i>

                <h2 class="h5 fw-bold mt-3">
                    هنوز محصولی ثبت نشده است
                </h2>

                <p class="text-body-secondary small mb-0">
                    محصولات ثبت‌شده در این بخش نمایش داده می‌شوند.
                </p>
            </div>
        </div>

    <?php else: ?>

        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام محصول</th>
                                <th>تعداد</th>
                                <th>تولیدکننده</th>
                                <th>نوع محصول</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php foreach ($products as $index => $product): ?>

                                <tr>
                                    <td><?= $index + 1 ?></td>

                                    <td>
                                        <?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($product['quantity'], ENT_QUOTES, 'UTF-8') ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($product['manufacturer'], ENT_QUOTES, 'UTF-8') ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($product['type'], ENT_QUOTES, 'UTF-8') ?>
                                    </td>
                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    <?php endif; ?>

</main>

<?php require __DIR__ . '/partials/footer.php'; ?>