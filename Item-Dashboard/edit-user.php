<?php
include 'config.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Fetch user details for editing
    $stmt = $pdo->prepare("SELECT * FROM Users WHERE user_id = ? AND is_deleted = 0");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    if (!$user) {
        echo "User not found.";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // Update user details
    $stmt = $pdo->prepare("UPDATE Users SET user_name = ?, user_mobile = ?, user_email = ?, user_address = ? WHERE user_id = ?");
    $stmt->execute([$name, $mobile, $email, $address, $user_id]);

    header("Location: admin-dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h1 class="my-4">Edit User</h1>

    <form method="POST">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo $user['user_name']; ?>" required>
        </div>
        <div class="form-group">
            <label>Mobile</label>
            <input type="text" name="mobile" class="form-control" value="<?php echo $user['user_mobile']; ?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo $user['user_email']; ?>" required>
        </div>
        <div class="form-group">
            <label>Address</label>
            <textarea name="address" class="form-control" required><?php echo $user['user_address']; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>

</body>
</html>
