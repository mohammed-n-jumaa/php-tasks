<?php include 'config.php'; ?>

<?php
// Handle category addition form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_category'])) {
    $category_name = $_POST['category_name'];
    $category_description = $_POST['category_description'];

    if (!empty($category_name) && !empty($category_description)) {
        // Insert the new category into the database
        $stmt = $pdo->prepare("INSERT INTO Category (category_name, category_description) VALUES (?, ?)");
        $stmt->execute([$category_name, $category_description]);

        // Redirect to avoid form resubmission
        header("Location: admin-dashboard.php");
        exit();
    } else {
        $error_message = "Please fill in all fields.";
    }
}

// Fetch all users
$stmt = $pdo->prepare("SELECT * FROM Users WHERE is_deleted = 0");
$stmt->execute();
$users = $stmt->fetchAll();

// Fetch all items
$stmt = $pdo->prepare("SELECT Items.*, Category.category_name FROM Items 
                        LEFT JOIN Category ON Items.category_id = Category.category_id
                        WHERE Items.is_deleted = 0");
$stmt->execute();
$items = $stmt->fetchAll();

// Fetch all orders
$stmt = $pdo->prepare("SELECT Orders.order_id, Users.user_name, Items.item_description 
                        FROM Orders 
                        JOIN Users ON Orders.user_order_id = Users.user_id 
                        JOIN Items ON Orders.user_item_order_id = Items.item_id 
                        WHERE Orders.is_deleted = 0");
$stmt->execute();
$orders = $stmt->fetchAll();

// Fetch all categories
$stmt = $pdo->prepare("SELECT * FROM Category WHERE is_deleted = 0");
$stmt->execute();
$categories = $stmt->fetchAll();
?>

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
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user['user_id']; ?></td>
                <td><?php echo $user['user_name']; ?></td>
                <td><?php echo $user['user_mobile']; ?></td>
                <td><?php echo $user['user_email']; ?></td>
                <td><?php echo $user['user_address']; ?></td>
                <td>
                    <a href="edit-user.php?id=<?php echo $user['user_id']; ?>" class="btn btn-primary">Edit</a>
                    <a href="delete-user.php?id=<?php echo $user['user_id']; ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
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
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?php echo $item['item_id']; ?></td>
                <td><?php echo $item['item_description']; ?></td>
                <td><img src="<?php echo $item['item_image']; ?>" alt="Item Image" style="width: 100px; height: auto;"></td>
                <td><?php echo $item['item_total_number']; ?></td>
                <td><?php echo $item['category_name']; ?></td>
                <td>
                    <a href="edit-item.php?id=<?php echo $item['item_id']; ?>" class="btn btn-primary">Edit</a>
                    <a href="delete-item.php?id=<?php echo $item['item_id']; ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
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
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?php echo $order['order_id']; ?></td>
                <td><?php echo $order['user_name']; ?></td>
                <td><?php echo $order['item_description']; ?></td>
                <td>
                    <a href="delete-order.php?id=<?php echo $order['order_id']; ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <a href="add-order.php" class="btn btn-success mb-4">Add New Order</a>

   

   

    <!-- Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Add New Category Form -->
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="category_name">Category Name</label>
                            <input type="text" name="category_name" id="category_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="category_description">Category Description</label>
                            <textarea name="category_description" id="category_description" class="form-control" required></textarea>
                        </div>
                        <button type="submit" name="add_category" class="btn btn-success">Add Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Display Existing Categories -->
    <h3 class="my-4">Existing Categories</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?php echo $category['category_id']; ?></td>
                <td><?php echo $category['category_name']; ?></td>
                <td><?php echo $category['category_description']; ?></td>
                <td>
                    <a href="edit-category.php?id=<?php echo $category['category_id']; ?>" class="btn btn-primary">Edit</a>
                    <a href="delete-category.php?id=<?php echo $category['category_id']; ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
 <!-- Button to trigger the modal -->
 <button type="button" class="btn btn-success mb-4" data-toggle="modal" data-target="#addCategoryModal">
        Add New Category
    </button>
</div>

<!-- Bootstrap and jQuery scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
