<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f9;
        }
        .container {
            text-align: center;
        }
        h1 {
            margin-bottom: 40px;
        }
        button {
            padding: 15px 30px;
            font-size: 18px;
            margin: 10px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
        }
        button:hover {
            background-color: #45a049;
        }
        .admin-btn {
            background-color: #2196F3;
        }
        .admin-btn:hover {
            background-color: #1e87d5;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Welcome to the LMS Portal</h1>
        <form method="POST" action="">
            <button type="submit" name="student" formaction="dashstu.php">Student</button>
            <button type="submit" name="admin" class="admin-btn" formaction="admin.html">Admin</button>
        </form>
    </div>

</body>
</html>