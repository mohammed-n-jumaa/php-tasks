<?php
session_start();
include('config.php');

// التحقق مما إذا كان المستخدم مسجل الدخول
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// جلب بيانات المستخدم من قاعدة البيانات
$sql = "SELECT * FROM users WHERE Id='$user_id'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    echo "User not found!";
    exit();
}

$successMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // تحديث صورة الملف الشخصي إذا تم تحميل صورة جديدة
    $profile_image = $user['Profile_Image']; // استخدام الصورة الحالية بشكل افتراضي
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['profile_image']['name'];
        $file_size = $_FILES['profile_image']['size'];
        $file_tmp = $_FILES['profile_image']['tmp_name'];

        $temp = explode('.', $file_name);
        $file_ext = strtolower(end($temp));

        if (in_array($file_ext, $allowed_extensions) && $file_size <= 2097152) { // 2MB max size
            $new_file_name = uniqid('', true) . '.' . $file_ext;
            $file_destination = 'uploads/' . $new_file_name;

            if (move_uploaded_file($file_tmp, $file_destination)) {
                $profile_image = $new_file_name; // تحديث الصورة الجديدة
            } else {
                $successMessage = "Failed to upload image.";
            }
        } else {
            $successMessage = "Invalid file type or size too large.";
        }
    }

    // تحديث السيرة الذاتية إذا تم تحميل CV جديد
    $cv_file = $user['CV_File']; // استخدام السيرة الذاتية الحالية بشكل افتراضي
    if (isset($_FILES['cv_file']) && $_FILES['cv_file']['error'] == 0) {
        $allowed_cv_extensions = array('pdf', 'doc', 'docx');
        $cv_name = $_FILES['cv_file']['name'];
        $cv_size = $_FILES['cv_file']['size'];
        $cv_tmp = $_FILES['cv_file']['tmp_name'];

        $cv_temp = explode('.', $cv_name);
        $cv_ext = strtolower(end($cv_temp));

        if (in_array($cv_ext, $allowed_cv_extensions) && $cv_size <= 2097152) { // 2MB max size
            $new_cv_name = uniqid('', true) . '.' . $cv_ext;
            $cv_destination = 'uploads/cvs/' . $new_cv_name;

            if (move_uploaded_file($cv_tmp, $cv_destination)) {
                $cv_file = $new_cv_name; // تحديث السيرة الذاتية الجديدة
            } else {
                $successMessage = "Failed to upload CV.";
            }
        } else {
            $successMessage = "Invalid CV file type or size too large.";
        }
    }

    // تحديث بيانات المستخدم
    $sql = "UPDATE users SET F_Name='$fname', L_Name='$lname', Email='$email', Profile_Image='$profile_image', CV_File='$cv_file' WHERE Id='$user_id'";
    if (mysqli_query($conn, $sql)) {
        // جلب البيانات المحدثة
        $sql = "SELECT * FROM users WHERE Id='$user_id'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);

        $successMessage = "Profile updated successfully!";
        // تحديث البريد الإلكتروني في الجلسة
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
    <title>User Profile</title>
    <link rel="stylesheet" href="profile-style.css">
    <style>
        /* تحسين التصميم */
        body {
            background-color: #f4f7f6;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .profile-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 700px;
            width: 100%;
            padding: 30px;
            margin: 20px;
        }

        .profile-header {
            text-align: center;
            padding: 20px;
            background-color: #1ab188;
            color: white;
            border-radius: 10px 10px 0 0;
            position: relative;
            z-index: 10;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .profile-header h1 {
            margin: 0;
            font-size: 32px;
        }

        .profile-header p {
            font-size: 16px;
            margin: 5px 0 0;
        }

        .profile-content {
            padding: 20px;
        }

        .profile-content img {
            display: block;
            margin: 20px auto;
            border-radius: 50%;
            max-width: 150px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .profile-card {
            background-color: #f9f9f9;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .profile-card h2 {
            margin-bottom: 15px;
            font-size: 22px;
            color: #333;
        }

        .profile-card input[type="text"],
        .profile-card input[type="email"],
        .profile-card input[type="file"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            margin-bottom: 15px;
        }

        .profile-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .profile-actions button,
        .profile-actions a {
            width: 48%;
            padding: 12px 0;
            background-color: #1ab188;
            color: white;
            border-radius: 5px;
            border: none;
            text-decoration: none;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            text-align: center;
        }

        .profile-actions button:hover,
        .profile-actions a:hover {
            background-color: #179b77;
        }

        .logout {
            background-color: #e74c3c;
        }

        .logout:hover {
            background-color: #c0392b;
        }

        .success-message {
            background-color: #28a745;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            display: none;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <h1>Welcome, <?php echo htmlspecialchars($user['F_Name']) . " " . htmlspecialchars($user['L_Name']); ?>!</h1>
            <p>Your Profile Information</p>
        </div>

        <div class="profile-content">
            <!-- Success Message -->
            <?php if ($successMessage): ?>
                <div id="successMessage" class="success-message"><?php echo htmlspecialchars($successMessage); ?></div>
            <?php endif; ?>

            <!-- Profile Picture -->
            <img src="uploads/<?php echo htmlspecialchars($user['Profile_Image']); ?>" alt="Profile Picture">

            <!-- Personal Details -->
            <form action="profile.php" method="post" enctype="multipart/form-data">
                <div class="profile-card">
                    <h2>Personal Details</h2>
                    <p><strong>First Name:</strong></p>
                    <input type="text" name="fname" value="<?php echo htmlspecialchars($user['F_Name']); ?>" required>

                    <p><strong>Last Name:</strong></p>
                    <input type="text" name="lname" value="<?php echo htmlspecialchars($user['L_Name']); ?>" required>

                    <p><strong>Email:</strong></p>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>" required>

                    <p><strong>Profile Picture:</strong></p>
                    <input type="file" name="profile_image" accept=".jpg, .jpeg, .png, .gif">

                    <p><strong>CV (PDF, DOC, DOCX):</strong></p>
                    <input type="file" name="cv_file" accept=".pdf, .doc, .docx">

                    <!-- عرض السيرة الذاتية الحالية -->
                    <?php if ($user['CV_File']): ?>
                        <p><strong>Current CV:</strong> <a href="uploads/cvs/<?php echo htmlspecialchars($user['CV_File']); ?>" download>Download CV</a></p>
                    <?php endif; ?>
                </div>

                <!-- Actions -->
                <div class="profile-actions">
                    <button type="submit">Save Changes</button>
                    <a href="logout.php" class="logout" style="background-color: #e74c3c; color: white; padding: 12px 20px; border-radius: 5px; text-decoration: none; font-size: 16px; text-align: center; display: inline-block; transition: background-color 0.3s ease;">Logout</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Show success message for 3 seconds, then hide it
        window.onload = function() {
            var successMessage = document.getElementById('successMessage');
            if (successMessage) {
                successMessage.style.display = 'block'; // Show message
                setTimeout(function() {
                    successMessage.style.display = 'none'; // Hide message after 3 seconds
                }, 3000);
            }
        };
    </script>
</body>
</html>
