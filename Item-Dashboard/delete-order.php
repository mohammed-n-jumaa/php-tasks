<?php
include 'config.php';

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // Soft delete the order
    $stmt = $pdo->prepare("UPDATE Orders SET is_deleted = 1 WHERE order_id = ?");
    $stmt->execute([$order_id]);

    header("Location: admin-dashboard.php");
    exit();
}
?>
