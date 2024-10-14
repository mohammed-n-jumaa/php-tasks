<?php
session_start();
include('config.php');

// تأكد من أن المستخدم هو المسؤول
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// جلب بيانات المستخدمين من قاعدة البيانات
$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error with SQL query: " . mysqli_error($conn));  
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="profile-style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background-color: #f4f7f6;
            font-family: 'Poppins', sans-serif;
        }
        .dashboard-container {
            max-width: 1100px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #1ab188;
            color: white;
            border-radius: 10px 10px 0 0;
        }
        .dashboard-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .logout-btn {
            background-color: #e74c3c;
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .logout-btn:hover {
            background-color: #c0392b;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px; /* تقليل حجم الخط للجدول */
        }
        table th, table td {
            padding: 10px; /* تقليل التباعد داخل الخلايا */
            border: 1px solid #ddd;
            text-align: left;
        }
        table th {
            background-color: #f0f0f0;
            font-weight: bold;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9; /* لون الصفوف بالتناوب */
        }
        tr:hover {
            background-color: #f1f1f1; /* تأثير التحويم على الصفوف */
        }
        .action-buttons a {
            padding: 6px 12px; /* تقليل حجم الأزرار */
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            font-size: 12px; /* تقليل حجم الخط للأزرار */
        }
        .btn-edit {
            background-color: #1ab188;
        }
        .btn-edit:hover {
            background-color: #16a085;
        }
        .btn-delete {
            background-color: #e74c3c;
        }
        .btn-delete:hover {
            background-color: #c0392b;
        }
        .profile-image {
            max-width: 50px;
            max-height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }
        .profile-image-container {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        @media (max-width: 768px) {
            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .logout-btn {
                margin-top: 10px;
            }
            table {
                font-size: 12px; /* تقليل حجم الخط على الشاشات الصغيرة */
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Admin Dashboard</h1>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Profile Picture</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>CV</th> <!-- عمود السيرة الذاتية -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td class="profile-image-container">
                        <?php if ($user['Profile_Image']): ?>
                            <img src="uploads/<?php echo $user['Profile_Image']; ?>" class="profile-image" alt="Profile Picture">
                        <?php else: ?>
                            <img src="uploads/default.jpg" class="profile-image" alt="No Image">
                        <?php endif; ?>
                    </td>
                    <td><?php echo $user['F_Name']; ?></td>
                    <td><?php echo $user['L_Name']; ?></td>
                    <td><?php echo $user['Email']; ?></td>
                    <td>
                        <?php if ($user['CV_File']): ?>
                            <a href="uploads/cvs/<?php echo $user['CV_File']; ?>" download>Download CV</a>
                        <?php else: ?>
                            No CV uploaded
                        <?php endif; ?>
                    </td>
                    <td class="action-buttons">
                        <a href="edit-user.php?id=<?php echo $user['Id']; ?>" class="btn-edit">Edit</a>
                        <a href="delete-user.php?id=<?php echo $user['Id']; ?>" class="btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
