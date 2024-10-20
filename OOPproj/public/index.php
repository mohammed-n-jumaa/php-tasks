<?php
// public/index.php
require_once __DIR__ . '/../app/controllers/AuthController.php';

$authController = new AuthController();
require_once __DIR__ . '/../app/views/login.php';

?>
