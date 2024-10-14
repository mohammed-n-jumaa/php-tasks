<?php
session_start();
include('config.php');

$successMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Registration block
    if (isset($_POST['register'])) {
        $fname = mysqli_real_escape_string($conn, $_POST['fname']);
        $lname = mysqli_real_escape_string($conn, $_POST['lname']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // التحقق من صحة الاسم الأول والاسم الأخير والبريد الإلكتروني وكلمة المرور
        if (!preg_match("/^[a-zA-Z]{2,50}$/", $fname)) {
            $successMessage = "First name must contain only letters and be between 2 and 50 characters.";
        } elseif (!preg_match("/^[a-zA-Z]{2,50}$/", $lname)) {
            $successMessage = "Last name must contain only letters and be between 2 and 50 characters.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $successMessage = "Invalid email format.";
        } elseif (strlen($password) < 8 || !preg_match("/[0-9]/", $password) || !preg_match("/[^\w]/", $password)) {
            $successMessage = "Password must be at least 8 characters long and include numbers and symbols.";
        } else {
            // Hash the password before storing it
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Check if the email already exists in the database
            $sql = "SELECT * FROM users WHERE Email='$email'";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                $successMessage = "Email already exists!";
            } else {
                // Check if the image is uploaded (اختياري)
                $profile_image = '';
                if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
                    $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
                    $file_name = $_FILES['profile_image']['name'];
                    $file_size = $_FILES['profile_image']['size'];
                    $file_tmp = $_FILES['profile_image']['tmp_name'];

                    $temp = explode('.', $file_name);
                    $file_ext = strtolower(end($temp));

                    if (in_array($file_ext, $allowed_extensions) && $file_size <= 2097152) {
                        $new_file_name = uniqid('', true) . '.' . $file_ext;
                        $file_destination = 'uploads/' . $new_file_name;

                        if (!is_dir('uploads/')) {
                            mkdir('uploads/', 0755, true);
                        }

                        if (move_uploaded_file($file_tmp, $file_destination)) {
                            $profile_image = $new_file_name;
                        } else {
                            $successMessage = "Failed to upload image.";
                        }
                    } else {
                        $successMessage = "Invalid file type or size too large.";
                    }
                }

                // Check if the CV is uploaded (اختياري)
                $cv = '';
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

                        if (!is_dir('uploads/cvs/')) {
                            mkdir('uploads/cvs/', 0755, true);
                        }

                        if (move_uploaded_file($cv_tmp, $cv_destination)) {
                            $cv = $cv_new_name;
                        } else {
                            $successMessage = "Failed to upload CV.";
                        }
                    } else {
                        $successMessage = "Invalid CV file type or size too large.";
                    }
                }

                // Only if everything passes, insert the user
                if (empty($successMessage)) {
                    $sql = "INSERT INTO users (F_Name, L_Name, Email, Password, Profile_Image, CV_File, Role) 
                            VALUES ('$fname', '$lname', '$email', '$hashed_password', '$profile_image', '$cv', 'user')";
                    if (mysqli_query($conn, $sql)) {
                        $successMessage = "You have registered successfully!";
                    } else {
                        $successMessage = "Error: " . mysqli_error($conn);
                    }
                }
            }
        }
    }

    // Login block
    if (isset($_POST['login'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = trim(mysqli_real_escape_string($conn, $_POST['password'])); // Make sure there's no trailing whitespace

        // Check if email exists
        $sql = "SELECT * FROM users WHERE Email='$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            // Verify the password
            if (password_verify($password, $user['Password'])) {
                // Start the session and set the cookie
                $_SESSION['user_id'] = $user['Id'];
                $_SESSION['email'] = $user['Email'];
                $_SESSION['role'] = $user['Role'];

                // Set cookies for 30 days
                setcookie('user_email', $user['Email'], time() + (86400 * 30), "/");
                setcookie('user_Fname', $user['F_Name'], time() + (86400 * 30), "/");
                setcookie('user_Lname', $user['L_Name'], time() + (86400 * 30), "/");


                if ($user['Role'] == 'admin') {
                    header('Location: admin-dashboard.php');
                } else {
                    header('Location: profile.php');
                }
                exit();
            } else {
                $successMessage = "Incorrect password!";
            }
        } else {
            $successMessage = "Email not found!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up and Log In</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form">
    <ul class="tab-group">
        <li class="tab active"><a href="#signup">Sign Up</a></li>
        <li class="tab"><a href="#login">Log In</a></li>
    </ul>

    <div class="tab-content">
        <!-- Success or Error Message Display -->
        <?php if ($successMessage): ?>
            <div class="success-message"><?php echo $successMessage; ?></div>
        <?php endif; ?>

        <!-- Sign Up Form -->
        <div id="signup">
            <h1>Sign Up for Free</h1>
            <form action="register.php" method="post" enctype="multipart/form-data">
                <div class="top-row">
                    <div class="field-wrap">
                        <label>First Name<span class="req">*</span></label>
                        <input type="text" name="fname" required autocomplete="off"/>
                    </div>
                    <div class="field-wrap">
                        <label>Last Name<span class="req">*</span></label>
                        <input type="text" name="lname" required autocomplete="off"/>
                    </div>
                </div>

                <div class="field-wrap">
                    <label>Email Address<span class="req">*</span></label>
                    <input type="email" name="email" required autocomplete="off"/>
                </div>

                <div class="field-wrap">
                    <label>Set A Password<span class="req">*</span></label>
                    <input type="password" name="password" required autocomplete="off"/>
                </div>

                <!-- حقل رفع الصورة (اختياري) -->
                <div class="field-wrap">
                    <input type="file" name="profile_image" accept=".jpg, .jpeg, .png, .gif"/>
                    <label>Upload Profile Picture (Optional)</label>
                </div>

                <!-- حقل رفع السيرة الذاتية (اختياري) -->
                <div class="field-wrap">
                    <input type="file" name="cv" accept=".pdf,.doc,.docx"/>
                    <label>Upload Your CV (Optional)</label>
                </div>

                <button type="submit" name="register" class="button button-block">Get Started</button>
            </form>
        </div>

        <!-- Log In Form -->
        <div id="login">
            <h1>Welcome Back!</h1>
            <form action="register.php" method="post">
                <div class="field-wrap">
                    <label>Email Address<span class="req">*</span></label>
                    <input type="email" name="email" required autocomplete="off"/>
                </div>
                <div class="field-wrap">
                    <label>Password<span class="req">*</span></label>
                    <input type="password" name="password" required autocomplete="off"/>
                </div>
                <button type="submit" name="login" class="button button-block">Log In</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="script.js"></script>
</body>
</html>
