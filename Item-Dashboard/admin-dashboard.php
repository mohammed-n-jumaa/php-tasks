<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h1 class="my-4">Admin Dashboard</h1>

    <!-- Users Management -->
    <h2>Manage Users</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Fetch users who are not soft deleted
        $stmt = $pdo->prepare("SELECT * FROM Users WHERE is_deleted = 0");
        $stmt->execute();
        $users = $stmt->fetchAll();

        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>{$user['user_id']}</td>";
            echo "<td>{$user['user_name']}</td>";
            echo "<td>{$user['user_mobile']}</td>";
            echo "<td>{$user['user_email']}</td>";
            echo "<td>{$user['user_address']}</td>";
            echo "<td>
                    <a href='edit-user.php?id={$user['user_id']}' class='btn btn-primary'>Edit</a>
                    <a href='delete-user.php?id={$user['user_id']}' class='btn btn-danger'>Delete</a>
                  </td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>

    <a href="add-user.php" class="btn btn-success mb-4">Add New User</a>

    <!-- Items Management -->
    <h2>Manage Items</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Image</th>
                <th>Total Number</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Fetch items that are not soft deleted
        $stmt = $pdo->prepare("SELECT * FROM Items WHERE is_deleted = 0");
        $stmt->execute();
        $items = $stmt->fetchAll();

        foreach ($items as $item) {
            echo "<tr>";
            echo "<td>{$item['item_id']}</td>";
            echo "<td>{$item['item_description']}</td>";
            // Display the image using the stored file path
            echo "<td><img src='{$item['item_image']}' alt='Item Image' style='width: 100px; height: auto;'></td>";
            echo "<td>{$item['item_total_number']}</td>";
            echo "<td>
                    <a href='edit-item.php?id={$item['item_id']}' class='btn btn-primary'>Edit</a>
                    <a href='delete-item.php?id={$item['item_id']}' class='btn btn-danger'>Delete</a>
                  </td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>

    <a href="add-item.php" class="btn btn-success mb-4">Add New Item</a>

    <!-- Orders Management -->
    <h2>Manage Orders</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User Name</th>
                <th>Item Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Fetch orders that are not soft deleted
        $stmt = $pdo->prepare("SELECT Orders.order_id, Users.user_name, Items.item_description 
                                FROM Orders 
                                JOIN Users ON Orders.user_order_id = Users.user_id 
                                JOIN Items ON Orders.user_item_order_id = Items.item_id 
                                WHERE Orders.is_deleted = 0");
        $stmt->execute();
        $orders = $stmt->fetchAll();

        foreach ($orders as $order) {
            echo "<tr>";
            echo "<td>{$order['order_id']}</td>";
            echo "<td>{$order['user_name']}</td>";
            echo "<td>{$order['item_description']}</td>";
            echo "<td>
                    <a href='delete-order.php?id={$order['order_id']}' class='btn btn-danger'>Delete</a>
                  </td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>

    <a href="add-order.php" class="btn btn-success mb-4">Add New Order</a>
</div>

</body>
</html>
