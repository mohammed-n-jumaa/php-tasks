<?php
include 'config.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Soft delete the user
    $stmt = $pdo->prepare("UPDATE Users SET is_deleted = 1 WHERE user_id = ?");
    $stmt->execute([$user_id]);

    header("Location: admin-dashboard.php");
    exit();
}
?>
