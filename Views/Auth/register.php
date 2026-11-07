<!DOCTYPE html>
<html lang="fa" dir="rtl">
    <head>
        <meta charset="utf-8">
        <title>ثبت نام</title>
    </head>
    <body>  

        <h1> فرم ثبت نام </h1>

        <form action="/register" method="post">

            <label for="mobile">شماره مبایل: </label>
            <input type="tel" id="mobile" name="mobile" required>
            <br><br>

            <label for="email"> ایمیل:</label>
            <input type="email" id="email" name="email" required>
            <br><br>
  
            <label for="username">نام کاربری:</label>
            <input type="text" id="username" name="username" required>
            <br><br>

            <label for="password">رمز عبور:</label>
            <input type="password" id="password" name="password" required>
            <br><br>

            <label for="confirm_password">تکرار رمز عبور:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <br><br>

            <button type="submit">ثبت نام</button>

        </form>

    </body>
        
</html>
