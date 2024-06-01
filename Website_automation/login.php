<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Login</title>
  <!-- Bootstrap CSS -->
  <link href="css/style.css" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!-- Navigation Header -->
<?php include('include/header.php'); ?>

<div class="container">
  <div class="row justify-content-center mt-5">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          User Login
        </div>
        <div class="card-body">
          <form action="login_process.php" method="POST">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary">Login</button>
          </form>
        </div>
      </div>
      <div class="mt-3">
        <p>Not registered yet? <a href="register.php">Register here</a></p>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<?php include('include/footer.php'); ?>
</body>
</html>
