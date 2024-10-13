<?php
session_start();

if (!isset($_GET['id']) || !isset($_SESSION['users'][$_GET['id']])) {
    header("Location: admin.php");
    exit();
}

$user_id = $_GET['id'];
$user = $_SESSION['users'][$user_id];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $full_name = $_POST['full_name'];
    $mobile = $_POST['mobile'];

    $_SESSION['users'][$user_id]['email'] = $email;
    $_SESSION['users'][$user_id]['full_name'] = $full_name;
    $_SESSION['users'][$user_id]['mobile'] = $mobile;

    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit User</h2>
        <form method="POST">
            <div class="form-group">
                <label>Email:</label>
                <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label>Full Name:</label>
                <input type="text" class="form-control" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
            </div>
            <div class="form-group">
                <label>Mobile:</label>
                <input type="text" class="form-control" name="mobile" value="<?php echo htmlspecialchars($user['mobile']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
