<?php
include 'config.php';

if (isset($_GET['id'])) {
    $category_id = $_GET['id'];

    // Fetch all items for the selected category
    $stmtItems = $pdo->prepare("SELECT * FROM Items WHERE category_id = ? AND is_deleted = 0");
    $stmtItems->execute([$category_id]);
    $items = $stmtItems->fetchAll();

    // Fetch category name
    $stmtCategory = $pdo->prepare("SELECT category_name FROM Category WHERE category_id = ?");
    $stmtCategory->execute([$category_id]);
    $category = $stmtCategory->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $category['category_name']; ?> Items</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <style>
        .fixed-size {
            width: 100%; /* Make the image take full width of the card */
            height: 200px; /* Fixed height for all images */
            object-fit: cover; /* Ensure image covers the box while maintaining aspect ratio */
        }
        .card {
            margin-bottom: 0; /* Remove extra spacing between cards */
        }
        .card-body {
            padding: 10px; /* Reduce padding inside the card */
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="my-4"><?php echo $category['category_name']; ?> Items</h1>

    <div class="row">
        <?php foreach ($items as $item): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <!-- Apply fixed-size class to all images -->
                    <img src="<?php echo $item['item_image']; ?>" class="card-img-top fixed-size" alt="Item Image">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?php echo $item['item_description']; ?></h5>
                        <p class="card-text">Total Number: <?php echo $item['item_total_number']; ?></p>
                        <!-- Pass category_id when adding item to basket -->
                        <a href="shopping-basket.php?add=<?php echo $item['item_id']; ?>&category_id=<?php echo $category_id; ?>" class="btn btn-primary">Add to Basket</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- زر الرجوع إلى صفحة Landing Page -->
    <a href="landing-page.php" class="btn btn-secondary mt-4">Go Back to Landing Page</a>

</div>

</body>
</html>
