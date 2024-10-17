<?php
include 'config.php';

if (isset($_GET['id'])) {
    $category_id = $_GET['id'];

    // تنفيذ الحذف الناعم عبر تحديث عمود is_deleted
    $stmt = $pdo->prepare("UPDATE Category SET is_deleted = 1 WHERE category_id = ?");
    $stmt->execute([$category_id]);

    // إعادة التوجيه إلى لوحة التحكم بعد الحذف
    header("Location: admin-dashboard.php");
    exit();
} else {
    echo "No category ID provided.";
    exit();
}
?>
