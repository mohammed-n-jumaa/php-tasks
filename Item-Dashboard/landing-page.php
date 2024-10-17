<?php
include 'config.php';

// Fetch all categories
$stmtCategories = $pdo->prepare("SELECT * FROM Category");
$stmtCategories->execute();
$categories = $stmtCategories->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h1 class="my-4">Available Categories</h1>

    <div class="row">
        <?php foreach ($categories as $category): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $category['category_name']; ?></h5>
                        <p class="card-text"><?php echo $category['category_description']; ?></p>
                        <a href="category-view.php?id=<?php echo $category['category_id']; ?>" class="btn btn-primary">View Items</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
