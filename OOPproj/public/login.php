<?php
// public/login.php
require_once __DIR__ . '/../app/controllers/AuthController.php';

$authController = new AuthController();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $authController->login();
} else {
    require_once __DIR__ . '/../app/views/login.php';
}
?>
