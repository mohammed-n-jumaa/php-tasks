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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .table img {
            max-width: 80px;
            height: auto;
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
    <h1 class="my-4 text-center">Admin Dashboard</h1>

    <!-- Users Management -->
    <h2>Manage Users</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
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
                    <a href="edit-user.php?id=<?php echo $user['user_id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                    <a href="delete-user.php?id=<?php echo $user['user_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <a href="add-user.php" class="btn btn-success mb-4">Add New User</a>

    <!-- Items Management -->
    <h2>Manage Items</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
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
                <td><img src="<?php echo $item['item_image']; ?>" alt="Item Image"></td>
                <td><?php echo $item['item_total_number']; ?></td>
                <td><?php echo $item['category_name']; ?></td>
                <td>
                    <a href="edit-item.php?id=<?php echo $item['item_id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                    <a href="delete-item.php?id=<?php echo $item['item_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <a href="add-item.php" class="btn btn-success mb-4">Add New Item</a>

    <!-- Orders Management -->
    <h2>Manage Orders</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
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
                    <a href="delete-order.php?id=<?php echo $order['order_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
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
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
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
                    <a href="edit-category.php?id=<?php echo $category['category_id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                    <a href="delete-category.php?id=<?php echo $category['category_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <!-- Button to trigger the modal -->
    <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
        Add New Category
    </button>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
