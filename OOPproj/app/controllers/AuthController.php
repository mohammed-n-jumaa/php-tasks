<?php
// app/controllers/AuthController.php

// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/User.php';

class AuthController {
    public function register() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = new User();
            $username = htmlspecialchars($_POST['username']);
            $password = $_POST['password'];
            $repeat_password = $_POST['repeat_password'];
            $email = htmlspecialchars($_POST['email']);

            if ($password === $repeat_password) {
                $result = $user->register($username, $password, $email);
                $this->redirect('/OOPPROJ/public/register.php', $result);
            } else {
                $this->redirect('/OOPPROJ/public/register.php', "Passwords do not match.");
            }
        }
    }

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = new User();
            $username = htmlspecialchars($_POST['username']);
            $password = $_POST['password'];

            $loggedInUser = $user->login($username, $password);

            if ($loggedInUser) {
                $_SESSION['username'] = $loggedInUser['username'];
                $this->redirect('/OOPPROJ/public/index.php', "Login successful!");
            } else {
                $this->redirect('/OOPPROJ/public/login.php', "Invalid credentials.");
            }
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        $this->redirect('/OOPPROJ/public/index.php', "You have been logged out.");
    }

    private function redirect($page, $message = "") {
        if ($message) {
            $_SESSION['message'] = $message;
        }
        header("Location: $page");
        exit;
    }
}
?>
