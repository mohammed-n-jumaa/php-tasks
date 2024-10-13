<?php
session_start();

// Predefined users list (if using sessions or from previous sign-ups)
$users = isset($_SESSION['users']) ? $_SESSION['users'] : [];
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    foreach ($users as $index => $user) {
        if ($user['email'] == $email && password_verify($password, $user['password'])) {
            $_SESSION['logged_in_user'] = $user;
            $_SESSION['users'][$index]['last_login'] = date("Y-m-d H:i:s");

            if ($email == "admin@example.com") {
                $_SESSION['admin_logged_in'] = true;
                header("Location: admin.php");
                exit();
            } else {
                header("Location: welcome.php");
                exit();
            }
        }
    }
    $error = "Invalid login credentials!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .container {
            max-width: 400px;
            margin-top: 20px;
        }
        .btn-lg {
            width: 100%;
        }
        .error-message {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Email:</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">Login</button>
        </form>
        <p class="mt-3">Don't have an account? <a href="signup.php">Sign Up</a></p>
    </div>
</body>
</html>
