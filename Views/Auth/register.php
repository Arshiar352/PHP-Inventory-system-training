<?php
$pageTitle = 'ثبت نام';
$bodyClass = 'auth-page';
$showNavbar = false;
require __DIR__ . '/../partials/head.php';
?>

<main class="min-vh-100 d-flex align-items-center justify-content-center py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-7 col-xl-6">
                <div class="card auth-card">
                    <div class="card-body p-4 p-md-5">

                        <div class="text-center mb-4">
                            <div class="auth-brand-icon mb-3">
                                <i class="bi bi-person-plus"></i>
                            </div>
                            <h1 class="h3 fw-bold mb-2">فرم ثبت نام</h1>
                            <p class="text-body-secondary small mb-0">برای ساخت حساب کاربری، اطلاعات زیر را تکمیل کنید.</p>
                        </div>

                        <?php if (isset($errors['general'])): ?>
                            <div class="alert alert-danger d-flex align-items-center gap-2" role="alert">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <div><?= htmlspecialchars($errors['general']) ?></div>
                            </div>
                        <?php endif; ?>

                        <form action="/register" method="post" novalidate>
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label for="mobile" class="form-label fw-medium">شماره موبایل</label>
                                    <div class="input-group <?= isset($errors['mobile']) ? 'has-validation' : '' ?>">
                                        <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                        <input type="tel"
                                               class="form-control <?= isset($errors['mobile']) ? 'is-invalid' : '' ?>"
                                               id="mobile"
                                               name="mobile"
                                               inputmode="numeric"
                                               minlength="11"
                                               maxlength="11"
                                               pattern="09[0-9]{9}"
                                               placeholder="09123456789"
                                               value="<?= htmlspecialchars($oldValues['mobile'] ?? '') ?>"
                                               autocomplete="tel"
                                               required>
                                        <?php if (isset($errors['mobile'])): ?>
                                            <div class="invalid-feedback"><?= htmlspecialchars($errors['mobile']) ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="email" class="form-label fw-medium">ایمیل</label>
                                    <div class="input-group <?= isset($errors['email']) ? 'has-validation' : '' ?>">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email"
                                               class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                                               id="email"
                                               name="email"
                                               placeholder="name@example.com"
                                               value="<?= htmlspecialchars($oldValues['email'] ?? '') ?>"
                                               autocomplete="email"
                                               required>
                                        <?php if (isset($errors['email'])): ?>
                                            <div class="invalid-feedback"><?= htmlspecialchars($errors['email']) ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="username" class="form-label fw-medium">نام کاربری</label>
                                    <div class="input-group <?= isset($errors['username']) ? 'has-validation' : '' ?>">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text"
                                               class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>"
                                               id="username"
                                               name="username"
                                               placeholder="نام کاربری دلخواه خود را وارد کنید"
                                               value="<?= htmlspecialchars($oldValues['username'] ?? '') ?>"
                                               autocomplete="username"
                                               required>
                                        <?php if (isset($errors['username'])): ?>
                                            <div class="invalid-feedback"><?= htmlspecialchars($errors['username']) ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="password" class="form-label fw-medium">رمز عبور</label>
                                    <div class="input-group <?= isset($errors['password']) ? 'has-validation' : '' ?>">
                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                        <input type="password"
                                               class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                                               id="password"
                                               name="password"
                                               placeholder="رمز عبور"
                                               autocomplete="new-password"
                                               required>
                                        <button class="btn btn-outline-secondary"
                                                type="button"
                                                data-toggle-password="password"
                                                aria-label="نمایش رمز عبور">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <?php if (isset($errors['password'])): ?>
                                            <div class="invalid-feedback"><?= htmlspecialchars($errors['password']) ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="confirm_password" class="form-label fw-medium">تکرار رمز عبور</label>
                                    <div class="input-group <?= isset($errors['confirm_password']) ? 'has-validation' : '' ?>">
                                        <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                                        <input type="password"
                                               class="form-control <?= isset($errors['confirm_password']) ? 'is-invalid' : '' ?>"
                                               id="confirm_password"
                                               name="confirm_password"
                                               placeholder="تکرار رمز عبور"
                                               autocomplete="new-password"
                                               required>
                                        <button class="btn btn-outline-secondary"
                                                type="button"
                                                data-toggle-password="confirm_password"
                                                aria-label="نمایش رمز عبور">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <?php if (isset($errors['confirm_password'])): ?>
                                            <div class="invalid-feedback"><?= htmlspecialchars($errors['confirm_password']) ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                                        <i class="bi bi-check2-circle ms-1"></i>
                                        ثبت نام
                                    </button>
                                </div>
                            </div>
                        </form>

                        <p class="text-center small text-body-secondary mt-4 mb-0">
                            قبلاً ثبت‌نام کرده‌اید؟
                            <a href="/login" class="fw-semibold text-decoration-none">وارد شوید</a>
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>
