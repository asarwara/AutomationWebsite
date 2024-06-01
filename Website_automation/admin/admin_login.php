<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .login-container {
            max-width: 400px;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 100px; /* Optional: adjust this value as needed */
        }

        h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #343a40;
            text-align: center;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 4px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <?php include('../include/header.php'); ?>   
    <div class="container">
        <div class="row justify-content-center">
            <div class="login-container">
                <h1>Admin Login</h1>
                <form action="process_admin_login.php" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
    <?php include('../include/footer.php'); ?>   
</body>
</html>
