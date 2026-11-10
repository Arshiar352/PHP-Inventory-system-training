<?php
$pageTitle = 'ورود به حساب کاربری';
$bodyClass = 'auth-page';
$showNavbar = false;
require __DIR__ . '/../partials/head.php';
?>

<main class="min-vh-100 d-flex align-items-center justify-content-center py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">
                <div class="card auth-card">
                    <div class="card-body p-4 p-md-5">

                        <div class="text-center mb-4">
                            <div class="auth-brand-icon mb-3">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <h1 class="h3 fw-bold mb-2">ورود به حساب کاربری</h1>
                            <p class="text-body-secondary small mb-0">برای ادامه، وارد حساب خود شوید.</p>
                        </div>

                        <?php if (isset($errors['login'])): ?>
                            <div class="alert alert-danger d-flex align-items-center gap-2" role="alert">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <div><?= htmlspecialchars($errors['login']) ?></div>
                            </div>
                        <?php endif; ?>

                        <form action="/login" method="POST">
                            <div class="mb-3">
                                <label for="login" class="form-label fw-medium">نام کاربری، ایمیل یا موبایل</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text"
                                           class="form-control"
                                           id="login"
                                           name="login"
                                           value="<?= htmlspecialchars($oldValues['login'] ?? '') ?>"
                                           placeholder="نام کاربری، ایمیل یا شماره موبایل"
                                           autocomplete="username"
                                           required
                                           autofocus>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-medium">رمز عبور</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password"
                                           class="form-control"
                                           id="password"
                                           name="password"
                                           placeholder="رمز عبور خود را وارد کنید"
                                           autocomplete="current-password"
                                           required>
                                    <button class="btn btn-outline-secondary"
                                            type="button"
                                            data-toggle-password="password"
                                            aria-label="نمایش رمز عبور">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                                <i class="bi bi-box-arrow-in-left ms-1"></i>
                                ورود
                            </button>
                        </form>

                        <p class="text-center small text-body-secondary mt-4 mb-0">
                            حساب کاربری ندارید؟
                            <a href="/register" class="fw-semibold text-decoration-none">ثبت‌نام کنید</a>
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require __DIR__ . '/../partials/footer.php'; ?>
