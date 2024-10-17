<?php
include 'config.php';

session_start();

// Fetch item details for items in the basket
$basket_items = [];
if (!empty($_SESSION['basket'])) {
    $ids = implode(',', array_keys($_SESSION['basket']));
    $stmt = $pdo->prepare("SELECT * FROM Items WHERE item_id IN ($ids)");
    $stmt->execute();
    $basket_items = $stmt->fetchAll();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle checkout
    $user_id = $_SESSION['user_id']; // Assuming you have a logged-in user session

    foreach ($basket_items as $item) {
        $item_id = $item['item_id'];
        $quantity = $_SESSION['basket'][$item_id];

        // Insert order for each item in the basket
        $stmt = $pdo->prepare("INSERT INTO Orders (user_order_id, user_item_order_id) VALUES (?, ?)");
        $stmt->execute([$user_id, $item_id]);

        // Optionally update the stock or total number in Items table
        $new_total = $item['item_total_number'] - $quantity;
        $stmtUpdate = $pdo->prepare("UPDATE Items SET item_total_number = ? WHERE item_id = ?");
        $stmtUpdate->execute([$new_total, $item_id]);
    }

    // Clear the basket after checkout
    unset($_SESSION['basket']);

    header("Location: success.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h1 class="my-4">Checkout</h1>

    <form method="POST">
        <button type="submit" class="btn btn-success">Confirm Purchase</button>
    </form>
</div>

</body>
</html>
