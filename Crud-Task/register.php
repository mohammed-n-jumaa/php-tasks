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
        
        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Check if the email already exists in the database
        $sql = "SELECT * FROM users WHERE Email='$email'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            $successMessage = "Email already exists!";
        } else {
            // Insert new user with hashed password
            $sql = "INSERT INTO users (F_Name, L_Name, Email, Password) VALUES ('$fname', '$lname', '$email', '$hashed_password')";
            if (mysqli_query($conn, $sql)) {
                $successMessage = "You have registered successfully!";
            } else {
                $successMessage = "Error: " . mysqli_error($conn);
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

            // Debugging: Show the entered password and hashed password
            echo "Entered password: " . $password . "<br>";
            echo "Hashed password from database: " . $user['Password'] . "<br>";

            // Verify the password
            if (password_verify($password, $user['Password'])) {
                // Password is correct, start the session and redirect
                $_SESSION['user_id'] = $user['Id'];
                $_SESSION['email'] = $user['Email'];
                header('Location: profile.php');
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
            <form action="register.php" method="post">
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
