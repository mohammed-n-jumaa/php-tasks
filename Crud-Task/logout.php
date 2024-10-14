<?php
// تسجيل الخروج
setcookie('user_email', '', time() - 3600, "/"); // حذف الكوكي
setcookie('user_Fname', '', time() - 3600, "/");  // حذف الكوكي
setcookie('user_Lname', '', time() - 3600, "/");  // حذف الكوكي


session_start();
session_destroy();
header('Location: register.php');
exit();
