<?php
session_start();

$users = isset($_SESSION['users']) ? $_SESSION['users'] : [];
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $familyname = $_POST['familyname'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $dob_day = $_POST['dob_day'];
    $dob_month = $_POST['dob_month'];
    $dob_year = $_POST['dob_year'];
    $dob = $dob_day . '-' . $dob_month . '-' . $dob_year;

    // Server-side validation

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Mobile validation (14 digits)
    if (!preg_match('/^\d{14}$/', $mobile)) {
        $errors[] = "Mobile number must be exactly 14 digits.";
    }

    // Full name validation (only letters)
    if (!preg_match('/^[a-zA-Z]+$/', $fname) || !preg_match('/^[a-zA-Z]+$/', $mname) || !preg_match('/^[a-zA-Z]+$/', $lname) || !preg_match('/^[a-zA-Z]+$/', $familyname)) {
        $errors[] = "Name fields must contain only letters.";
    }

    // Password validation (at least 8 characters, including uppercase, lowercase, number, special character, and no spaces)
    if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[\W]/', $password) || preg_match('/\s/', $password)) {
        $errors[] = "Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one number, one special character, and no spaces.";
    }

    // Confirm password validation
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // Date of birth validation (above 16 years)
    $age = date("Y") - $dob_year;
    if ($age < 16) {
        $errors[] = "You must be at least 16 years old to register.";
    }

    // If no errors, register the user
    if (empty($errors)) {
        $new_user = [
            'email' => $email,
            'mobile' => $mobile,
            'full_name' => "$fname $mname $lname $familyname",
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'dob' => $dob,
            'date_created' => date("Y-m-d H:i:s"),
            'last_login' => null,
        ];

        $users[] = $new_user;
        $_SESSION['users'] = $users;
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .container {
            max-width: 500px;
            margin-top: 20px;
        }
        .btn-lg {
            width: 100%;
            margin-top: 20px;
        }
        .error-messages {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sign Up</h2>
        
        <!-- Display PHP errors -->
        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" onsubmit="return validateForm()">
            <!-- Email -->
            <div class="form-group">
                <label>Email:</label>
                <input type="email" class="form-control" name="email" required>
            </div>

            <!-- Mobile -->
            <div class="form-group">
                <label>Mobile:</label>
                <input type="text" class="form-control" name="mobile" maxlength="14" required>
            </div>

            <!-- Full Name -->
            <div class="form-group">
                <label>First Name:</label>
                <input type="text" class="form-control" name="fname" required>
                <label>Middle Name:</label>
                <input type="text" class="form-control mt-2" name="mname" required>
                <label>Last Name:</label>
                <input type="text" class="form-control mt-2" name="lname" required>
                <label>Family Name:</label>
                <input type="text" class="form-control mt-2" name="familyname" required>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label>Password:</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label>Confirm Password:</label>
                <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
            </div>

            <!-- Date of Birth -->
            <div class="form-group">
                <label>Date of Birth (DD/MM/YYYY):</label>
                <input type="text" class="form-control" name="dob_day" maxlength="2" placeholder="Day" required>
                <input type="text" class="form-control mt-2" name="dob_month" maxlength="2" placeholder="Month" required>
                <input type="text" class="form-control mt-2" name="dob_year" maxlength="4" placeholder="Year" required>
            </div>

            <button type="submit" class="btn btn-danger btn-lg">Sign Up</button>
        </form>

        <p class="mt-3">Already have an account? <a href="login.php">Login</a></p>
    </div>

    <script>
        // Client-side validation
        function validateForm() {
            let password = document.getElementById('password').value;
            let confirm_password = document.getElementById('confirm_password').value;
            let passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])(?!.*\s).{8,}$/;
            
            if (!passwordRegex.test(password)) {
                alert("Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one number, one special character, and no spaces.");
                return false;
            }

            if (password !== confirm_password) {
                alert("Passwords do not match!");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
