<?php

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

         if ($_SERVER['REQUEST_METHOD'] === "GET") {

             require_once __DIR__ . '/../Views/Auth/register.php';

        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $mobile = $_POST['mobile'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

            if (empty($username) || empty($email) || empty($mobile) || empty($password)  || empty($confirmPassword)) {

                echo 'Please fill all fields.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

                echo 'Email is invalid.';
            } elseif ($password !== $confirmPassword) {

                echo 'Passwords do not match!';
            }
            
            
            else {

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            }

            
        }
        

    }

}