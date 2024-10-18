<?php include 'config.php'; ?>

<?php
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    // Fetch items for the specific category
    $stmt = $pdo->prepare("SELECT * FROM Items WHERE category_id = ? AND is_deleted = 0");
    $stmt->execute([$category_id]);
    $items = $stmt->fetchAll();
} else {
    echo "No category selected.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9; /* لون خلفية مريح */
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card img {
            border-radius: 12px 12px 0 0;
            height: 200px;
            object-fit: cover;
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
                    <a class="nav-link" href="view-items.php">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact-us.php">Contact Us</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Items Section -->
<div class="container my-5">
    <h1 class="text-center mb-5">Items in Category</h1>
    <div class="row">
        <?php foreach ($items as $item): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="<?php echo $item['item_image']; ?>" class="card-img-top" alt="Item Image">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $item['item_description']; ?></h5>
                        <p class="card-text">Total Number: <?php echo $item['item_total_number']; ?></p>
                        <a href="item-details.php?item_id=<?php echo $item['item_id']; ?>" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
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
