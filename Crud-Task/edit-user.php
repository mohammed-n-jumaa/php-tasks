<?php
session_start();
include('config.php');

// Verify if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Check if the user ID is passed in the URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Fetch the user data
    $sql = "SELECT * FROM users WHERE Id='$user_id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);  // Fetch user data
    } else {
        echo "User not found!";
        exit();
    }
} else {
    echo "Invalid user ID!";
    exit();
}

$success = false; // Flag to indicate success
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Handle image upload if a new image is uploaded
    $profile_image = $user['Profile_Image']; // Use the existing image by default
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['profile_image']['name'];
        $file_size = $_FILES['profile_image']['size'];
        $file_tmp = $_FILES['profile_image']['tmp_name'];

        $temp = explode('.', $file_name);  // Temporary variable fix
        $file_ext = strtolower(end($temp));

        if (in_array($file_ext, $allowed_extensions) && $file_size <= 2097152) {
            $new_file_name = uniqid('', true) . '.' . $file_ext;
            $file_destination = 'uploads/' . $new_file_name;

            if (move_uploaded_file($file_tmp, $file_destination)) {
                $profile_image = $new_file_name; // Update with new image
            } else {
                echo "Failed to upload image.";
            }
        } else {
            echo "Invalid file type or size too large.";
        }
    }

    // Handle CV upload if a new CV is uploaded
    $cv = $user['CV_File']; // Use the existing CV by default
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] == 0) {
        $allowed_extensions_cv = array('pdf', 'doc', 'docx');
        $cv_name = $_FILES['cv']['name'];
        $cv_size = $_FILES['cv']['size'];
        $cv_tmp = $_FILES['cv']['tmp_name'];

        $cv_temp = explode('.', $cv_name);
        $cv_ext = strtolower(end($cv_temp));

        if (in_array($cv_ext, $allowed_extensions_cv) && $cv_size <= 2097152) {
            $cv_new_name = uniqid('', true) . '.' . $cv_ext;
            $cv_destination = 'uploads/cvs/' . $cv_new_name;

            if (move_uploaded_file($cv_tmp, $cv_destination)) {
                $cv = $cv_new_name; // Update with new CV
            } else {
                echo "Failed to upload CV.";
            }
        } else {
            echo "Invalid CV file type or size too large.";
        }
    }

    // Update user information
    $sql = "UPDATE users SET F_Name='$fname', L_Name='$lname', Email='$email', Profile_Image='$profile_image', CV_File='$cv' WHERE Id='$user_id'";
    if (mysqli_query($conn, $sql)) {
        $success = true; // Set success flag
    } else {
        echo "Error updating user: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="profile-style.css">
</head>
<body>
    <div class="form-container">
        <h1>Edit User</h1>

        <?php if ($success): ?>
        <div id="successMessage" class="success-message">
            Update successful!
        </div>
        <script>
            document.getElementById('successMessage').style.display = 'block';
            setTimeout(function () {
                window.location.href = 'admin-dashboard.php';  // Redirect after success
            }, 3000);  // 3 seconds delay
        </script>
        <?php endif; ?>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="fname">First Name</label>
                <input type="text" name="fname" value="<?php echo $user['F_Name']; ?>" required>
            </div>

            <div class="form-group">
                <label for="lname">Last Name</label>
                <input type="text" name="lname" value="<?php echo $user['L_Name']; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" value="<?php echo $user['Email']; ?>" required>
            </div>

            <!-- Display the current image -->
            <div class="form-group">
                <label>Current Profile Picture:</label><br>
                <?php if ($user['Profile_Image']): ?>
                    <img src="uploads/<?php echo $user['Profile_Image']; ?>" alt="Profile Picture" style="max-width: 150px;">
                <?php else: ?>
                    <p>No image available</p>
                <?php endif; ?>
            </div>

            <!-- Option to upload a new image -->
            <div class="form-group">
                <label for="profile_image">Change Profile Picture</label>
                <input type="file" name="profile_image" accept=".jpg, .jpeg, .png, .gif">
            </div>

            <!-- Display the current CV -->
            <div class="form-group">
                <label>Current CV:</label><br>
                <?php if ($user['CV_File']): ?>
                    <a href="uploads/cvs/<?php echo $user['CV_File']; ?>" download>Download CV</a>
                <?php else: ?>
                    <p>No CV uploaded</p>
                <?php endif; ?>
            </div>

            <!-- Option to upload a new CV -->
            <div class="form-group">
                <label for="cv">Change CV</label>
                <input type="file" name="cv" accept=".pdf,.doc,.docx">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">Update User</button>
            </div>
        </form>
    </div>
</body>
</html>
