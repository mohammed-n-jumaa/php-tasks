<?php include 'config.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description = $_POST['description'];
    $total_number = $_POST['total_number'];
    $category_id = $_POST['category_id'];

    // Image upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is an image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Save item data into the database
            $stmt = $pdo->prepare("INSERT INTO Items (item_description, item_image, item_total_number, category_id) VALUES (?, ?, ?, ?)");
            $stmt->execute([$description, $target_file, $total_number, $category_id]);
            header("Location: admin-dashboard.php");
            exit();
        } else {
            $error = "Sorry, there was an error uploading your file.";
        }
    } else {
        $error = "File is not an image.";
    }
}

// Fetch categories for dropdown
$stmt = $pdo->prepare("SELECT * FROM Category WHERE is_deleted = 0");
$stmt->execute();
$categories = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item</title>
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
                    <a class="nav-link" href="./landing-page">Home</a>
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
    <h1 class="my-4 text-center">Add New Item</h1>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="description" class="form-label">Item Description</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Item Image</label>
            <input type="file" name="image" id="image" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="total_number" class="form-label">Total Number</label>
            <input type="number" name="total_number" id="total_number" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" id="category_id" class="form-select" required>
                <option value="">-- Select Category --</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
                <?php endforeach; ?>
            </select>
            <div class="d-flex">
            <button type="submit" class="btn btn-success mt-3">Add Item</button>
            <a href="admin-dashboard.php" class="btn btn-secondary mt-3">Go Back</a>
</div>
    </form>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
