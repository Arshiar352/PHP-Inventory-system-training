
<?php

require_once __DIR__ . '/../Config/Database.php';

use Hekmatinasser\Verta\Verta;

class AuthController
{


    public function showLoginGet()
    {
        $oldValues = $_SESSION['login_old_values'] ?? [];
        $errors = $_SESSION['login_errors'] ?? [];

        unset($_SESSION['login_errors']);
        unset($_SESSION['login_old_values']);

        require_once __DIR__ . '/../Views/Auth/login.php';
    }




    public function loginPost()
    {
        global $pdo;

        $oldValues = [];
        $errors = [];

        $login = $_POST['login'] ?? '';
        $password = $_POST['password'] ?? '';

        $oldValues['login'] = $login;

        if (empty($login) || empty($password)) {
            $errors['login'] = 'Please fill in all fields.';
        }

        if (!empty($errors)) {
            $_SESSION['login_old_values'] = $oldValues;
            $_SESSION['login_errors'] = $errors;

            header('Location: /login');
            exit;
        }

        $sql = "SELECT id, username, mobile, email, password
                FROM users
                WHERE username = ?
                OR mobile = ?
                OR email = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$login, $login, $login]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user !== false && password_verify($password, $user['password'])) {

            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];

            header('Location: /home');
            exit;
        } else {

            $errors['login'] = 'Invalid username, email, mobile or password.';

            $_SESSION['login_old_values'] = $oldValues;
            $_SESSION['login_errors'] = $errors;

            header('Location: /login');
            exit;
        }
    }




    public function showRegisterGet()
    {
        $oldValues = $_SESSION['old_values'] ?? [];
        $errors = $_SESSION['errors'] ?? [];

        unset($_SESSION['old_values']);
        unset($_SESSION['errors']);

        require_once __DIR__ . '/../Views/Auth/register.php';
    }




    public function registerPost()
    {
        global $pdo;

        $errors = [];

        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $mobile = trim($_POST['mobile'] ?? '');

        $mobile = $this->convertToEnglishNumbers($mobile);

        $birthDateInput = trim($_POST['birth_date'] ?? '');
        $birthDate = $this->convertToEnglishNumbers($birthDateInput);

        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $oldValues = [
            'username' => $username,
            'email' => $email,
            'mobile' => $mobile,
            'birth_date' => $birthDateInput
        ];

        $passCheck = $password !== $confirmPassword;

        if (
            empty($username) ||
            empty($email) ||
            empty($mobile) ||
            empty($password) ||
            empty($birthDate) ||
            empty($confirmPassword)
        ) {
            $errors['general'] = 'Please fill all fields.';
        }

        if (empty($password) || empty($confirmPassword)) {
            $errors['password'] = 'Please enter your password.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address.';
        }

        if (!preg_match('/^09[0-9]{9}$/', $mobile)) {
            $errors['mobile'] = 'Please enter a valid phone number.';
        }

        if (empty($username)) {
            $errors['username'] = 'Please enter your username.';
        }

        if ($passCheck) {
            $errors['confirm_password'] = 'Passwords do not match!';
        }

        if (empty($birthDate)) {
            $errors['birth_date'] = 'Please enter your birth date.';
        }

        $gregorianDate = null;

        if (!empty($birthDate)) {
            try {
                $dateCheck = Verta::parse($birthDate);
                $gregorianDate = $dateCheck->toCarbon()->format('Y-m-d');
            } catch (Throwable $e) {
                $errors['birth_date'] = 'Your birth date is invalid.';
            }
        }

        if (!empty($errors)) {
            $_SESSION['old_values'] = $oldValues;
            $_SESSION['errors'] = $errors;

            header('Location: /register');
            exit;
        }


        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username]);

        $usernameResult = $stmt->fetch();
        $usernameExists = ($usernameResult !== false);

        if ($usernameExists) {
            $errors['username'] = 'Username already exists.';
        }


        $sql = "SELECT id FROM users WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);

        $emailResult = $stmt->fetch();
        $emailExists = ($emailResult !== false);

        if ($emailExists) {
            $errors['email'] = 'Email already exists.';
        }


        $sql = "SELECT id FROM users WHERE mobile = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$mobile]);

        $mobileResult = $stmt->fetch();
        $mobileExists = ($mobileResult !== false);

        if ($mobileExists) {
            $errors['mobile'] = 'Phone number already exists.';
        }

        if (!$usernameExists && !$emailExists && !$mobileExists) {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users(username, email, mobile, password, birth_date)
                    VALUES(?, ?, ?, ?, ?)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $username,
                $email,
                $mobile,
                $hashedPassword,
                $gregorianDate
            ]);

            header('Location: /login');
            exit;
        } elseif (!empty($errors)) {

            $_SESSION['old_values'] = $oldValues;
            $_SESSION['errors'] = $errors;

            header('Location: /register');
            exit;
        }
    }




    public function logout()
    {
        $_SESSION = [];

        $params = session_get_cookie_params();

        setcookie(
            session_name(),
            '',
            [
                'expires' => time() - 3600,
                'path' => $params['path'],
                'domain' => $params['domain'],
                'secure' => $params['secure'],
                'httponly' => $params['httponly'],
                'samesite' => $params['samesite'],
                'partitioned' => $params['partitioned']
            ]
        );

        session_destroy();

        header('Location: /login');
        exit;
    }




    private function convertToEnglishNumbers(string $str): string
    {
        return strtr($str, [
            '۰' => '0',
            '۱' => '1',
            '۲' => '2',
            '۳' => '3',
            '۴' => '4',
            '۵' => '5',
            '۶' => '6',
            '۷' => '7',
            '۸' => '8',
            '۹' => '9',

            '٠' => '0',
            '١' => '1',
            '٢' => '2',
            '٣' => '3',
            '٤' => '4',
            '٥' => '5',
            '٦' => '6',
            '٧' => '7',
            '٨' => '8',
            '٩' => '9'
        ]);
    }
}
