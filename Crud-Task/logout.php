<?php
session_start();

// Destroy session and redirect to login/register page
session_destroy();

header('Location: register.php');
exit();
?>
