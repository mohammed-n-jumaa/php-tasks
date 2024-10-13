<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>

</head>

<body>
    <?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!isset($_SESSION["users"])) {
            $_SESSION['users'] = [];
        }

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $newUser = [
            "name" => $name,
            "email" => $email,
            "password" => $password,
        ];

        $_SESSION["users"][] = $newUser;
    }
    ?>

    <form method="POST">
        <label>Name: </label><input type="text" name="name" required><br>
        <label>E-mail: </label><input type="email" name="email" required><br>
        <label>Password: </label><input type="password" name="password" required><br>
        <input type="submit" value="Submit">
    </form>

    <?php
    if (isset($_SESSION["users"]) && count($_SESSION["users"]) > 0) {
        echo "<h2>Registered Users</h2>";
        echo "<button id='toggleBtn' onclick='toggleTable()'>Hide Table</button><br><br>";
        echo "<table border='1' id='userTable'>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Password</th>
                </tr>";

        foreach ($_SESSION["users"] as $user) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($user["name"]) . "</td>";
            echo "<td>" . htmlspecialchars($user["email"]) . "</td>";
            echo "<td>" . htmlspecialchars($user["password"]) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No users registered yet.</p>";
    }
    ?>
    <script>
    function toggleTable() {
        var table = document.getElementById("userTable");
        var btn = document.getElementById("toggleBtn");
        if (table.style.display === "none") {
            table.style.display = "table";
            btn.textContent = "Hide Table";
        } else {
            table.style.display = "none";
            btn.textContent = "View Table";
        }
    }
    </script>
</body>

</html>