<?php
include 'config.php';

if (isset($_GET['id'])) {
    $item_id = $_GET['id'];

    // Fetch item details for editing
    $stmt = $pdo->prepare("SELECT * FROM Items WHERE item_id = ? AND is_deleted = 0");
    $stmt->execute([$item_id]);
    $item = $stmt->fetch();

    if (!$item) {
        echo "Item not found.";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description = $_POST['description'];
    $total_number = $_POST['total_number'];

    // Handle image upload
    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is an actual image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Update item with new image
                $stmt = $pdo->prepare("UPDATE Items SET item_description = ?, item_image = ?, item_total_number = ? WHERE item_id = ?");
                $stmt->execute([$description, $target_file, $total_number, $item_id]);
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "File is not an image.";
        }
    } else {
        // Update item without changing the image
        $stmt = $pdo->prepare("UPDATE Items SET item_description = ?, item_total_number = ? WHERE item_id = ?");
        $stmt->execute([$description, $total_number, $item_id]);
    }

    header("Location: admin-dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h1 class="my-4">Edit Item</h1>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Item Description</label>
            <textarea name="description" class="form-control" required><?php echo $item['item_description']; ?></textarea>
        </div>
        <div class="form-group">
            <label>Item Image (Leave blank to keep current image)</label>
            <input type="file" name="image" class="form-control">
        </div>
        <div class="form-group">
            <label>Total Number</label>
            <input type="number" name="total_number" class="form-control" value="<?php echo $item['item_total_number']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Item</button>
    </form>
</div>

</body>
</html>
