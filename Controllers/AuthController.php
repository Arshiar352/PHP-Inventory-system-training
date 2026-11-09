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

        $mobile = trim($_POST['mobile'] ?? '');

        $mobile = strtr($mobile, [
            '۰' => '0', '۱' => '1', '۲' => '2',
            '۳' => '3', '۴' => '4', '۵' => '5',
            '۶' => '6', '۷' => '7', '۸' => '8',
            '۹' => '9',
            '٠' => '0', '١' => '1', '٢' => '2',
            '٣' => '3', '٤' => '4', '٥' => '5',
            '٦' => '6', '٧' => '7', '٨' => '8',
            '٩' => '9'
        ]);

        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $oldValues = [
        'username' => $username,
        'email' => $email,
        'mobile' => $mobile
        ];

        $passCheck = $password !== $confirmPassword;


       
            if (empty($username) || empty($email) || empty($mobile) || empty($password)  || empty($confirmPassword)) {

                $errors['general'] = 'Please fill all fields.';
            } 

            if ((empty($password)) || (empty($confirmPassword))) {

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

                $errors['confirmPassword'] = 'Passwords do not match!';
            } 
            
            if (!empty($errors)) {

                require_once __DIR__ . '/../Views/Auth/register.php';
            
                } else {

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

                             require_once __DIR__ . '/../Views/Auth/register.php';
                    } 
                } 
            }     
        }
    } 



