<?php
// public/logout.php
require_once __DIR__ . '/../app/controllers/AuthController.php';

$authController = new AuthController();
$authController->logout();
?>
