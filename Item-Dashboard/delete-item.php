<?php
include 'config.php';

if (isset($_GET['id'])) {
    $item_id = $_GET['id'];

    $stmt = $pdo->prepare("UPDATE Items SET is_deleted = 1 WHERE item_id = ?");
    $stmt->execute([$item_id]);

    header("Location: admin-dashboard.php");
    exit();
}
?>
