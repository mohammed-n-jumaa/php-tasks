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

$successMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Update user information in the database
    $sql = "UPDATE users SET F_Name='$fname', L_Name='$lname', Email='$email' WHERE Id='$user_id'";
    
    if (mysqli_query($conn, $sql)) {
        $successMessage = "Profile updated successfully!";
        // Update session email
        $_SESSION['email'] = $email;
    } else {
        $successMessage = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="profile-style.css">
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <h1>Edit Your Profile</h1>
        </div>

        <div class="profile-content">
            <!-- Success Message -->
            <?php if ($successMessage): ?>
                <div class="success-message"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            
            <form action="edit-profile.php" method="post">
                <div class="profile-card">
                    <h2>Personal Details</h2>
                    <p><strong>First Name:</strong></p>
                    <input type="text" name="fname" value="<?php echo $user['F_Name']; ?>" required>
                    
                    <p><strong>Last Name:</strong></p>
                    <input type="text" name="lname" value="<?php echo $user['L_Name']; ?>" required>
                    
                    <p><strong>Email:</strong></p>
                    <input type="email" name="email" value="<?php echo $user['Email']; ?>" required>
                </div>

                <div class="profile-actions">
                    <button type="submit" class="btn">Save Changes</button>
                    <a href="profile.php" class="btn logout">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>