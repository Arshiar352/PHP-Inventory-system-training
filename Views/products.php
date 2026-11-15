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

    <?php if (!empty($errors)): ?>
        <?php foreach ($errors as $error): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Add Product -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">

            <h2 class="h5 fw-bold mb-3">افزودن محصول</h2>

            <form action="/products" method="POST">

                <input type="hidden" name="action" value="create">

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">نام محصول</label>
                        <input type="text" name="name"
                            class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">تعداد</label>
                        <input type="number" name="quantity"
                            min="0" step="1"
                            class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">تولیدکننده</label>
                        <input type="text" name="manufacturer"
                            class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">نوع محصول</label>
                        <input type="text" name="type"
                            class="form-control" required>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary mt-3">
                    ثبت محصول
                </button>

            </form>
        </div>
    </div>

    <!-- Edit Product -->
    <?php if (is_array($editProduct)): ?>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">

                <h2 class="h5 fw-bold mb-3">ویرایش محصول</h2>

                <form action="/products" method="POST">

                    <input type="hidden" name="action" value="update">

                    <input type="hidden" name="id"
                        value="<?= (int) $editProduct['id'] ?>">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">نام محصول</label>
                            <input type="text" name="name"
                                class="form-control"
                                value="<?= htmlspecialchars($editProduct['name'], ENT_QUOTES, 'UTF-8') ?>"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">تعداد</label>
                            <input type="number" name="quantity"
                                min="0" step="1"
                                class="form-control"
                                value="<?= (int) $editProduct['quantity'] ?>"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">تولیدکننده</label>
                            <input type="text" name="manufacturer"
                                class="form-control"
                                value="<?= htmlspecialchars($editProduct['manufacturer'], ENT_QUOTES, 'UTF-8') ?>"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">نوع محصول</label>
                            <input type="text" name="type"
                                class="form-control"
                                value="<?= htmlspecialchars($editProduct['type'], ENT_QUOTES, 'UTF-8') ?>"
                                required>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-success mt-3">
                        ذخیره تغییرات
                    </button>

                    <a href="/products" class="btn btn-secondary mt-3">
                        انصراف
                    </a>

                </form>
            </div>
        </div>

    <?php endif; ?>

    <!-- Products List -->
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
                                <th>عملیات</th>
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

                                    <td class="d-flex gap-2">

                                        <a href="/products?edit=<?= (int) $product['id'] ?>"
                                            class="btn btn-warning btn-sm">
                                            ویرایش
                                        </a>

                                        <form action="/products" method="POST"
                                            onsubmit="return confirm('از حذف این محصول مطمئنی؟')">

                                            <input type="hidden" name="action" value="delete">

                                            <input type="hidden" name="id"
                                                value="<?= (int) $product['id'] ?>">

                                            <button type="submit"
                                                class="btn btn-danger btn-sm">
                                                حذف
                                            </button>

                                        </form>

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