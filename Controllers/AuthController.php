<?php

require_once __DIR__  . '/../Config/Database.php';

class AuthController {

    public function showLogin() {

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

             require_once __DIR__ . '/../Views/Auth/login.php';
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $login = $_POST['login'] ?? '';
            $password = $_POST['password'] ?? '';



            if ((empty($login)) && (empty($password))) {

                echo 'You must fill the fields.';
            
            } elseif ((empty($login))) {

                echo 'Please enter your username, email or mobile.';
            } elseif  (empty($password)) {

                echo 'Please enter your password.';
            } elseif (filter_var($login, FILTER_VALIDATE_EMAIL)) {
                
                echo 'Login is Email.';
            } else {

                echo 'Fields are valid.'; // logged in as number or username!
            }
        }
    }


    public function showRegister() {

    $oldValues =[];
    $errors = [];

         if ($_SERVER['REQUEST_METHOD'] === "GET") {

            global $pdo;

             require_once __DIR__ . '/../Views/Auth/register.php';

        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

        global $pdo;
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $mobile = $_POST['mobile'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $oldValues = [
        'username' => $username,
        'email' => $email,
        'mobile' => $mobile
        ];

        $passCheck = [$password !== $confirmPassword];



            if (empty($username) || empty($email) || empty($mobile) || empty($password)  || empty($confirmPassword)) {

                $error[''] = 'Please fill all fields.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

                $error['email'] = 'Please enter your email address.';
            } elseif ($passCheck) {

                $error['password, confirmPassword'] = 'Passwords do not match!';
            } elseif (!is_numeric($mobile)) {

                $error['mobile'] = 'Please enter your Phone Number.';
            }
            
            
            else {

                $sql = "SELECT id FROM users WHERE username = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$username]);

                $usernameResult = $stmt->fetch();
                $usernameExists = ($usernameResult !== false);

                $sql = "SELECT id FROM users WHERE email = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$email]);

                $emailResult = $stmt->fetch();
                $emailExists = ($emailResult !== false);

                $sql = "SELECT id FROM users WHERE mobile = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$mobile]);

                $mobileResult = $stmt->fetch();
                $mobileExists = ($mobileResult !== false);


                        if ($usernameExists) {

                        $errors['username'] = 'Username already exists.';
                    }

                       if ($emailExists) {

                        $errors['email'] = 'Email already exists.';
                    }

                       if ($mobileExists) {

                        $errors['mobile'] = 'Phone number already exists.';
                    }


                    if (!$usernameExists && !$emailExists && !$mobileExists) {

                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        $sql = "INSERT INTO users(username, email, mobile, password)
                        VALUES(?, ?, ?, ?)";
                        $stmt = $pdo -> prepare($sql);
                        $stmt -> execute([$username, $email, $mobile, $hashedPassword]);

                        header('Location: /login');
                        exit;
                } else {
                 require_once __DIR__ . '/../ٰViews/Auth/register.php';
                } 
            }

        }

    }
}