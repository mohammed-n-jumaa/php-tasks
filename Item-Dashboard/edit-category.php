<?php
include 'config.php';

// التحقق من وجود معرف الفئة في عنوان URL
if (isset($_GET['id'])) {
    $category_id = $_GET['id'];

    // جلب بيانات الفئة لتعديلها
    $stmt = $pdo->prepare("SELECT * FROM Category WHERE category_id = ? AND is_deleted = 0");
    $stmt->execute([$category_id]);
    $category = $stmt->fetch();

    if (!$category) {
        echo "Category not found.";
        exit();
    }
} else {
    echo "No category ID provided.";
    exit();
}

// معالجة النموذج عند تقديمه
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = $_POST['category_name'];
    $category_description = $_POST['category_description'];

    if (!empty($category_name) && !empty($category_description)) {
        // تحديث الفئة في قاعدة البيانات
        $stmt = $pdo->prepare("UPDATE Category SET category_name = ?, category_description = ? WHERE category_id = ?");
        $stmt->execute([$category_name, $category_description, $category_id]);

        // إعادة التوجيه إلى لوحة التحكم بعد التعديل
        header("Location: admin-dashboard.php");
        exit();
    } else {
        $error_message = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h1 class="my-4">Edit Category</h1>

    <!-- عرض نموذج تعديل الفئة -->
    <form method="POST" action="">
        <div class="form-group">
            <label for="category_name">Category Name</label>
            <input type="text" name="category_name" id="category_name" class="form-control" value="<?php echo $category['category_name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="category_description">Category Description</label>
            <textarea name="category_description" id="category_description" class="form-control" required><?php echo $category['category_description']; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Category</button>
    </form>

    <!-- عرض رسالة الخطأ عند عدم ملء الحقول -->
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger mt-2">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

</div>

</body>
</html>
