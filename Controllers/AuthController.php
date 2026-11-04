<?php

class AuthController {

    public function showLogin() {
       require_once __DIR__ . '/../Views/Auth/login.php';
    }


    public function showRegister() {
        require_once __DIR__ . '/../Views/Auth/register.php';
    }

}