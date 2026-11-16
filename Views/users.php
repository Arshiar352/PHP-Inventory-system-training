<?php

$pageTitle = 'پروفایل کاربری';
$bodyClass = 'bg-body-tertiary';
$showNavbar = true;

require __DIR__ . '/partials/head.php';

$profilePicture = $user['profile_picture'] ?? null;

?>

<main class="container py-4">

    <h1 class="h3 fw-bold mb-4">پروفایل کاربری</h1>


    <?php if (!empty($success)): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>


    <!-- نمایش خطاها -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li>
                        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>


    <div class="card shadow-sm border-0">
        <div class="card-body p-4">

            <form
                action="/users"
                method="POST"
                enctype="multipart/form-data">


                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">


                <!-- عکس پروفایل -->
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        عکس پروفایل
                    </label>

                    <div class="d-flex align-items-center gap-3 flex-wrap">

                        <?php if ($profilePicture): ?>

                            <img
                                src="<?= htmlspecialchars($profilePicture, ENT_QUOTES, 'UTF-8') ?>"
                                alt="Profile Picture"
                                width="90"
                                height="90"
                                class="rounded-circle border"
                                style="object-fit: cover;">

                        <?php else: ?>

                            <div
                                class="rounded-circle bg-secondary-subtle d-flex align-items-center justify-content-center"
                                style="width: 90px; height: 90px;">

                                <i class="bi bi-person fs-1 text-secondary"></i>

                            </div>

                        <?php endif; ?>


                        <div>
                            <input
                                type="file"
                                name="profile_picture"
                                class="form-control"
                                accept="image/jpeg,image/png,image/webp">

                            <small class="text-body-secondary">
                                فرمت‌های مجاز: JPG، PNG و WEBP
                                - حداکثر حجم: ۲ مگابایت
                            </small>
                        </div>

                    </div>
                </div>


                <hr>



                <div class="mb-3">

                    <label for="username" class="form-label">
                        نام کاربری
                    </label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        class="form-control"
                        maxlength="50"
                        value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>"
                        required>

                </div>



                <div class="mb-3">

                    <label class="form-label">
                        ایمیل
                    </label>

                    <input
                        type="email"
                        class="form-control"
                        value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>"
                        disabled>

                </div>



                <div class="mb-3">

                    <label class="form-label">
                        شماره موبایل
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>"
                        disabled>

                </div>



                <div class="mb-4">

                    <label class="form-label">
                        تاریخ تولد
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="<?= htmlspecialchars($user['birth_date'] ?? 'ثبت نشده', ENT_QUOTES, 'UTF-8') ?>"
                        disabled>

                </div>


                <button type="submit" class="btn btn-primary">
                    ذخیره تغییرات
                </button>

            </form>

        </div>
    </div>

</main>

<?php require __DIR__ . '/partials/footer.php'; ?>