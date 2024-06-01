<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Registration</title>
  <!-- Bootstrap CSS -->
  <link href="css/style.css" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!-- Navigation Header -->
<?php include('include/header.php'); ?>
<?php
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
  }
    if (isset($_SESSION['error_message'])) {
        echo "<div class='alert alert-danger'>" . $_SESSION['error_message'] . "</div>";
        unset($_SESSION['error_message']);
    }
    ?>

<div class="container">
  <div class="row justify-content-center mt-5">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          User Registration
        </div>
        <div class="card-body">
          <form action="registration_process.php" method="POST">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="phone">Phone</label>
              <input type="text" name="phone" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="confirm_password">Confirm Password</label>
              <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="address">Address</label>
              <textarea name="address" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" name="register" class="btn btn-primary">Register</button>
          </form>
        </div>
      </div>
      <div class="mt-3">
        <p>Already registered? <a href="login.php">Login here</a></p>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<?php include('include/footer.php'); ?>
</body>
</html>
