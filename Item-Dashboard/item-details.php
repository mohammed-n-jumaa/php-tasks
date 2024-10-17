<?php
include 'config.php';

if (isset($_GET['id'])) {
    $item_id = $_GET['id'];

    // Fetch item details
    $stmtItem = $pdo->prepare("SELECT * FROM Items WHERE item_id = ? AND is_deleted = 0");
    $stmtItem->execute([$item_id]);
    $item = $stmtItem->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h1 class="my-4">Item Details</h1>

    <div class="card mb-4">
        <img src="<?php echo $item['item_image']; ?>" class="card-img-top" alt="Item Image">
        <div class="card-body">
            <h5 class="card-title"><?php echo $item['item_description']; ?></h5>
            <p class="card-text">Total Number: <?php echo $item['item_total_number']; ?></p>
            <a href="category-view.php?id=<?php echo $item['category_id']; ?>" class="btn btn-primary">Back to Category</a>
        </div>
    </div>
</div>

</body>
</html>
