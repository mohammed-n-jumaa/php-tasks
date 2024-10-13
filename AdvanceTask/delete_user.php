<?php
session_start();

if (isset($_GET['id']) && isset($_SESSION['users'][$_GET['id']])) {
    unset($_SESSION['users'][$_GET['id']]);
    $_SESSION['users'] = array_values($_SESSION['users']);  // Reindex the array
}

header("Location: admin.php");
exit();
