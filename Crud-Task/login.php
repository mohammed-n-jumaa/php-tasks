<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM users WHERE Email='$email'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['Password'])) {
            $_SESSION['user_id'] = $user['Id'];
            $_SESSION['email'] = $user['Email'];
            $_SESSION['role'] = $user['Role'];

            if ($user['Role'] == 'admin') {
                header('Location: admin-dashboard.php');
            } else {
                header('Location: profile.php');
            }
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "Email not found!";
    }
}
?>