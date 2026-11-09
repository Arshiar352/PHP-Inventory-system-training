<!DOCTYPE html>
<html lang="fa" dir="rtl">
    <head>
        <meta charset="utf-8">
        <title>ثبت نام</title>
    </head>
    <body>  

        <h1> فرم ثبت نام </h1>

        <form action="/register" method="post">
            <?php if (isset($errors['general'])): ?>
            <p><?= htmlspecialchars($errors['general']) ?></p>
            <?php endif; ?>

            <label for="mobile">شماره مبایل: </label>
            <input type="tel" id="mobile" name="mobile" value="<?= htmlspecialchars($oldValues['mobile'] ?? '') ?>" >
            <?php
                if (isset($errors['mobile'])) {
                    echo $errors['mobile'];
                }
            ?>
            <br><br>

            <label for="email"> ایمیل:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($oldValues['email'] ?? '') ?>" >
            <?php
                if (isset($errors['email'])) {
                    echo $errors['email'];
                }
            ?>
            <br><br>
  
            <label for="username">نام کاربری:</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($oldValues['username'] ?? '') ?>" >
            <?php
                if (isset($errors['username'])) {
                    echo $errors['username'];
                }
            ?>
            <br><br>

            <label for="password">رمز عبور:</label>
            <input type="password" id="password" name="password" >
            <?php
                if (isset($errors['password'])) {
                    echo $errors['password'];
                }
            ?>
            <br><br>

            <label for="confirm_password">تکرار رمز عبور:</label>
            <input type="password" id="confirm_password" name="confirm_password" >
            <?php
                if (isset($errors['password'])) {
                    echo $errors['password'];
                }
            ?>
            <br><br>

            <button type="submit">ثبت نام</button>

        </form>

    </body>
        
</html>
