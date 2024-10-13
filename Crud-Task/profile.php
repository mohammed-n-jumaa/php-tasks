<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: register.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE Id='$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="profile-style.css">
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <h1>Welcome, <?php echo $user['F_Name'] . " " . $user['L_Name']; ?>!</h1>
            <p>Your Profile Information</p>
        </div>

        <div class="profile-content">
            <div class="profile-card">
                <h2>Personal Details</h2>
                <p><strong>First Name:</strong> <?php echo $user['F_Name']; ?></p>
                <p><strong>Last Name:</strong> <?php echo $user['L_Name']; ?></p>
                <p><strong>Email:</strong> <?php echo $user['Email']; ?></p>
                <p><strong>Password:</strong> ********</p>
            </div>

            <div class="profile-actions">
                <a href="edit-profile.php" class="btn">Edit Profile</a>
                <a href="logout.php" class="btn logout">Logout</a>
            </div>
        </div>
    </div>
</body>
</html>
