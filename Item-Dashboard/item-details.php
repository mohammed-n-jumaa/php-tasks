<?php
session_start(); // بدء الجلسة

include 'config.php'; // تضمين ملف الاتصال بقاعدة البيانات

// تحقق من وجود طلب إضافة إلى السلة
if (isset($_POST['add_to_cart'])) {
    $item_id = $_POST['item_id'];
    $quantity = 1; // الكمية الافتراضية

    // إذا كانت السلة غير موجودة، قم بإنشائها
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // إذا كان العنصر موجودًا بالفعل في السلة، قم بزيادة الكمية
    if (isset($_SESSION['cart'][$item_id])) {
        $_SESSION['cart'][$item_id] += $quantity;
    } else {
        // أضف العنصر الجديد إلى السلة
        $_SESSION['cart'][$item_id] = $quantity;
    }

    // إعادة توجيه المستخدم إلى صفحة السلة
    header("Location: shopping-basket.php");
    exit();
}

// استرداد بيانات المنتج من قاعدة البيانات
if (isset($_GET['item_id'])) {
    $item_id = $_GET['item_id'];
    $stmt = $pdo->prepare("SELECT Items.*, Category.category_name FROM Items 
                            JOIN Category ON Items.category_id = Category.category_id 
                            WHERE Items.item_id = ?");
    $stmt->execute([$item_id]);
    $item = $stmt->fetch();
} else {
    echo "Item not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
        }
        .btn-primary {
            background-color: #ff7043;
            border: none;
        }
        .btn-primary:hover {
            background-color: #ff8a65;
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
                    <a class="nav-link" href="category-view.php">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="shopping-basket.php">Basket</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Item Details -->
<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <img src="<?php echo $item['item_image']; ?>" class="img-fluid" alt="Item Image">
        </div>
        <div class="col-md-6">
            <h2><?php echo $item['item_description']; ?></h2>
            <p><strong>Total Number:</strong> <?php echo $item['item_total_number']; ?></p>
            <p><strong>Category:</strong> <?php echo $item['category_name']; ?></p>
            <form method="post" action="">
                <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
                <button type="submit" name="add_to_cart" class="btn btn-success">Add to Basket</button>
            </form>
            <a href="category-view.php" class="btn btn-secondary mt-3">Back to Categories</a>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-light text-center p-4">
    <div class="container">
        <p>&copy; 2024 BrandName. All Rights Reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
