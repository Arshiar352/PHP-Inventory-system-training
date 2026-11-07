<?php

class AuthController {

    public function showLogin() {
       require_once __DIR__ . '/../Views/Auth/login.php';
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