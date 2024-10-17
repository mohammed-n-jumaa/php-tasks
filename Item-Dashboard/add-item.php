<?php
include 'config.php';

// Fetch all categories for the dropdown
$stmtCategories = $pdo->prepare("SELECT category_id, category_name FROM Category");
$stmtCategories->execute();
$categories = $stmtCategories->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description = $_POST['description'];
    $total_number = $_POST['total_number'];
    $category_id = $_POST['category_id'];

    // Image upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Save item details with category ID
            $stmt = $pdo->prepare("INSERT INTO Items (item_description, item_image, item_total_number, category_id) VALUES (?, ?, ?, ?)");
            $stmt->execute([$description, $target_file, $total_number, $category_id]);

            header("Location: admin-dashboard.php");
            exit();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "File is not an image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h1 class="my-4">Add New Item</h1>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Item Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label>Item Image</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Total Number</label>
            <input type="number" name="total_number" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Category</label>
            <select name="category_id" class="form-control" required>
                <option value="">-- Select Category --</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Add Item</button>
    </form>
</div>

</body>
</html>
