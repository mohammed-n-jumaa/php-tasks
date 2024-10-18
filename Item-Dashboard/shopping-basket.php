<?php
session_start();
include 'config.php'; // تضمين ملف الاتصال بقاعدة البيانات

// التحقق من وجود السلة
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<div class='container'><div class='alert alert-warning text-center'>Your shopping basket is empty.</div></div>";
    exit();
}

// عملية إضافة أو إزالة العناصر
if (isset($_POST['action'])) {
    $item_id = $_POST['item_id'];

    // جلب البيانات من قاعدة البيانات للتحقق من الكمية المتاحة
    $stmt = $pdo->prepare("SELECT item_total_number FROM Items WHERE item_id = ?");
    $stmt->execute([$item_id]);
    $item = $stmt->fetch();

    if ($item) {
        $available_quantity = $item['item_total_number'];

        if ($_POST['action'] == 'add') {
            if ($_SESSION['cart'][$item_id] < $available_quantity) {
                $_SESSION['cart'][$item_id]++;
            } else {
                $_SESSION['message'] = "You've reached the maximum available quantity for this item.";
            }
        } elseif ($_POST['action'] == 'remove') {
            if ($_SESSION['cart'][$item_id] > 1) {
                $_SESSION['cart'][$item_id]--;
            } else {
                unset($_SESSION['cart'][$item_id]);
            }
        }
    }
}

// جلب العناصر الموجودة في السلة
$items_in_cart = $_SESSION['cart'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Basket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .cart-table {
            margin-top: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            background-color: #ffffff;
        }
        .cart-header {
            background-color: #007bff;
            color: white;
            text-align: center;
            font-size: 1.5rem;
            padding: 15px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .table tbody tr {
            vertical-align: middle;
        }
        .cart-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .alert-warning {
            background-color: #ffcc00;
            color: black;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="landing-page.php">BrandName</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="view-items.php">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="shopping-basket.php">Basket</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Shopping Basket Section -->
<div class="container my-5">
    <div class="cart-header">Your Shopping Basket</div>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-warning text-center">
            <?php
            echo $_SESSION['message'];
            unset($_SESSION['message']);
            ?>
        </div>
    <?php endif; ?>

    <table class="table table-hover cart-table">
        <thead class="table-dark">
            <tr>
                <th>Item</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($items_in_cart as $item_id => $quantity): ?>
            <?php
            // جلب بيانات العنصر من قاعدة البيانات
            $stmt = $pdo->prepare("SELECT item_description FROM Items WHERE item_id = ?");
            $stmt->execute([$item_id]);
            $item = $stmt->fetch();
            ?>
            <tr>
                <td><?php echo $item['item_description']; ?></td>
                <td class="text-center"><?php echo $quantity; ?></td>
                <td class="text-center">
                    <form method="post" style="display:inline-block;">
                        <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
                        <button type="submit" name="action" value="add" class="btn btn-success btn-sm">Add</button>
                    </form>
                    <form method="post" style="display:inline-block;">
                        <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
                        <button type="submit" name="action" value="remove" class="btn btn-danger btn-sm">Remove</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="cart-footer">
        <a href="checkout.php" class="btn btn-primary btn-lg">Checkout</a>
        <a href="category-view.php" class="btn btn-secondary btn-lg">Continue Shopping</a>
    </div>
</div>

<!-- Footer -->
<footer class="bg-light text-center p-4 mt-5">
    <div class="container">
        <p>&copy; 2024 BrandName. All Rights Reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
