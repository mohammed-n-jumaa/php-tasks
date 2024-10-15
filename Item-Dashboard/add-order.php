
<?php
include 'config.php';

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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h1 class="my-4">Add New Order</h1>

    <form method="POST">
        <div class="form-group">
            <label for="user_order_id">Select User</label>
            <select name="user_order_id" class="form-control" required>
                <option value="">-- Select User --</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?php echo $user['user_id']; ?>"><?php echo $user['user_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="user_item_order_id">Select Item</label>
            <select name="user_item_order_id" class="form-control" required>
                <option value="">-- Select Item --</option>
                <?php foreach ($items as $item): ?>
                    <option value="<?php echo $item['item_id']; ?>"><?php echo $item['item_description']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Add Order</button>
    </form>
</div>

</body>
</html>
