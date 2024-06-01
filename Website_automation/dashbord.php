<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Include the database connection file
    include 'config/db_connect.php';

    // Fetch the customer profile information from the database
    $customer_id = $_SESSION['user_id'];
    $query = "SELECT name, email, phone FROM customer WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $customer_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $name, $email, $phone);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Initialize orders array
    $orders = [];

    // Check if the show orders button is clicked
    if (isset($_POST['show_orders'])) {
        // Fetch orders from the database for the logged-in user
        $order_query = "SELECT * FROM orders WHERE customer_id = ?";
        $order_stmt = mysqli_prepare($conn, $order_query);
        mysqli_stmt_bind_param($order_stmt, "i", $customer_id);
        mysqli_stmt_execute($order_stmt);
        $order_result = mysqli_stmt_get_result($order_stmt);
        $orders = mysqli_fetch_all($order_result, MYSQLI_ASSOC);
        mysqli_stmt_close($order_stmt);
    }
} else {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
  <link href="css/style.css" rel="stylesheet">
</head>

<body>
<?php include('include/header.php'); ?>
<div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($name); ?>!</h1>
    
    <!-- Display customer profile information here -->
    <p>Name: <?php echo htmlspecialchars($name); ?></p>
    <p>Email: <?php echo htmlspecialchars($email); ?></p>
    <p>Phone: <?php echo htmlspecialchars($phone); ?></p>
    <!-- Add more profile information fields as needed -->
    
    <!-- Buttons for profile update and showing orders -->
    <form action="" method="post">
        <button type="submit" class="btn btn-primary" name="update_profile">Update Profile</button>
        <button type="submit" class="btn btn-primary" name="show_orders">Show Orders</button>
    </form>

    <?php
    // Check if the update profile button is clicked
    if (isset($_POST['update_profile'])) {
        // Display the update profile form
        echo '
        <form action="update_profile.php" method="post">
            <!-- Input fields for updating profile information -->
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="' . htmlspecialchars($name) . '" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="' . htmlspecialchars($email) . '" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="' . htmlspecialchars($phone) . '" required>
            </div>
            
            <!-- Add more profile update fields as needed -->
            
            <!-- Update button -->
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>';
    }

    // Check if the show orders button is clicked and display orders
    if (isset($_POST['show_orders'])) {
        if (empty($orders)) {
            echo '<p>No orders found.</p>';
        } else {
            echo '
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Cost</th>
                        <th>Shipping Address</th>
                        <th>Billing Name</th>
                        <th>Payment Status</th>
                    </tr>
                </thead>
                <tbody>';
            foreach ($orders as $order) {
                echo '
                    <tr>
                        <td>' . htmlspecialchars($order['order_id']) . '</td>
                        <td>' . htmlspecialchars($order['cost']) . '</td>
                        <td>' . htmlspecialchars($order['shipping_address']) . '</td>
                        <td>' . htmlspecialchars($order['billing_name']) . '</td>
                        <td>' . htmlspecialchars($order['payment_status']) . '</td>
                        
                    </tr>';
            }
            echo '
                </tbody>
            </table>';
        }
    }
    ?>

</div>
<!-- Footer -->
<?php include('include/footer.php'); ?>

</body>
</html>
