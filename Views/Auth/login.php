<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ورود به حساب کاربری</title>
</head>
<body>

    <h1>ورود به حساب کاربری</h1>

    <form action="/login" method="POST">

        <label for="login">نام کاربری، ایمیل یا موبایل:</label>
        <input type="text" id="login" name="login" >
        <?php if (isset($errors['login'])): ?>
            <p><?= htmlspecialchars($errors['login']) ?></p>
        <?php endif; ?>
        <br><br>

        <label for="password">رمز عبور:</label>
        <input type="password" id="password" name="password" >
        <?php if (isset($errors['login'])): ?>
            <p><?= htmlspecialchars($errors['login']) ?></p>
        <?php endif; ?>

        <br><br>

        <button type="submit">ورود</button>

    </form>

</body>
</html>
