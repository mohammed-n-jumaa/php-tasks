<?php
include 'config.php';

session_start();
if (!isset($_SESSION['basket'])) {
    $_SESSION['basket'] = [];
}

// Check if category_id is passed in URL and store it in session
if (isset($_GET['category_id'])) {
    $_SESSION['category_id'] = $_GET['category_id'];
}

// Retrieve category_id from session
$category_id = isset($_SESSION['category_id']) ? $_SESSION['category_id'] : null;

// Variable to hold the error message
$error_message = '';

// Add item to basket
if (isset($_GET['add'])) {
    $item_id = $_GET['add'];

    // Fetch the item details from the database to check available quantity
    $stmt = $pdo->prepare("SELECT item_total_number FROM Items WHERE item_id = ?");
    $stmt->execute([$item_id]);
    $item = $stmt->fetch();

    if ($item) {
        $available_quantity = $item['item_total_number'];

        // Check if there's enough stock
        if (isset($_SESSION['basket'][$item_id])) {
            $current_quantity = $_SESSION['basket'][$item_id];
            if ($current_quantity < $available_quantity) {
                // Increase the quantity in the basket if stock is available
                $_SESSION['basket'][$item_id]++;
            } else {
                // If no stock is available, set an error message
                $error_message = 'Sorry, no more stock available for this item.';
            }
        } else {
            // If the item is not in the basket, add it with quantity 1 if stock is available
            if ($available_quantity > 0) {
                $_SESSION['basket'][$item_id] = 1;
            } else {
                $error_message = 'Sorry, this item is out of stock.';
            }
        }
    }
}

// Remove item from basket
if (isset($_GET['remove'])) {
    $item_id = $_GET['remove'];
    if (isset($_SESSION['basket'][$item_id])) {
        $_SESSION['basket'][$item_id]--;
        if ($_SESSION['basket'][$item_id] == 0) {
            unset($_SESSION['basket'][$item_id]);
        }
    }
}

// Fetch item details for items in the basket
$basket_items = [];
if (!empty($_SESSION['basket'])) {
    $ids = implode(',', array_keys($_SESSION['basket']));
    $stmt = $pdo->prepare("SELECT * FROM Items WHERE item_id IN ($ids)");
    $stmt->execute();
    $basket_items = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Basket</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h1 class="my-4">Your Shopping Basket</h1>

    <!-- Display error message if any -->
    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($basket_items as $item): ?>
            <tr>
                <td><?php echo $item['item_description']; ?></td>
                <td><?php echo $_SESSION['basket'][$item['item_id']]; ?></td>
                <td>
                    <a href="shopping-basket.php?add=<?php echo $item['item_id']; ?>" class="btn btn-success">Add</a>
                    <a href="shopping-basket.php?remove=<?php echo $item['item_id']; ?>" class="btn btn-danger">Remove</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-between mt-4">
        <a href="checkout.php" class="btn btn-primary">Checkout</a>

        <!-- Use category_id for Go Back button -->
        <a href="category-view.php?id=<?php echo $category_id; ?>" class="btn btn-secondary">Go Back</a>
    </div>
</div>

</body>
</html>
