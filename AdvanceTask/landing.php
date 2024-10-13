<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .container {
            text-align: center;
        }
        h1 {
            font-size: 2.5rem;
            font-weight: bold;
        }
        p {
            color: #6c757d;
            font-size: 1.1rem;
        }
        .btn {
            width: 300px;
            border-radius: 50px;
            padding: 15px;
            font-size: 1.2rem;
            margin-top: 20px;
        }
        .btn-login {
            background-color: #007bff;
            color: white;
        }
        .btn-signup {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Hello There!</h1>
        <p>Automatic identity verification which enables you to verify your identity</p>
        
        <a href="login.php" class="btn btn-login">Login</a>
        <a href="signup.php" class="btn btn-signup">Sign UP</a>
    </div>
</body>
</html>
