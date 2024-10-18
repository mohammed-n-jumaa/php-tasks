<?php include 'config.php'; ?>

<?php
// Fetch all users for the dropdown
$stmtUsers = $pdo->prepare("SELECT user_id, user_name FROM Users WHERE is_deleted = 0");
$stmtUsers->execute();
$users = $stmtUsers->fetchAll();

// Fetch all items for the dropdown
$stmtItems = $pdo->prepare("SELECT item_id, item_description FROM Items WHERE is_deleted = 0");
$stmtItems->execute();
$items = $stmtItems->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_order_id = $_POST['user_order_id'];
    $user_item_order_id = $_POST['user_item_order_id'];

    // Insert the new order
    $stmt = $pdo->prepare("INSERT INTO Orders (user_order_id, user_item_order_id) VALUES (?, ?)");
    $stmt->execute([$user_order_id, $user_item_order_id]);

    header("Location: admin-dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./landing-page.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./category-view.php?id=2">Products</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container">
    <h1 class="my-4 text-center">Add New Order</h1>

    <form method="POST">
        <div class="mb-3">
            <label for="user_order_id" class="form-label">Select User</label>
            <select name="user_order_id" id="user_order_id" class="form-select" required>
                <option value="">-- Select User --</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?php echo $user['user_id']; ?>"><?php echo $user['user_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="user_item_order_id" class="form-label">Select Item</label>
            <select name="user_item_order_id" id="user_item_order_id" class="form-select" required>
                <option value="">-- Select Item --</option>
                <?php foreach ($items as $item): ?>
                    <option value="<?php echo $item['item_id']; ?>"><?php echo $item['item_description']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
          <div d-flex>
        <button type="submit" class="btn btn-success mt-3">Add Order</button>
      <a href="admin-dashboard.php" class="btn btn-secondary mt-3">Go Back</a>
</div>
  </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
