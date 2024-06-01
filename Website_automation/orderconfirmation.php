<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
include('config/db_connect.php');

// Retrieve the billing name from the session
$billing_name = $_SESSION['billing_name'];

// Fetch order details from the database using the billing name
$query = "SELECT order_id, customer_id, cost, shipping_address, billing_name, payment_status 
          FROM orders WHERE billing_name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $billing_name);
$stmt->execute();
$result = $stmt->get_result();

// Check if order exists
if ($result->num_rows > 0) {
    $order = $result->fetch_assoc();
} else {
    $error_message = "Order not found.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <!-- Bootstrap CSS -->
    <link href="css/style.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        h1 {
            color: #337ab7;
            text-align: center;
        }
        .message {
            margin-top: 20px;
            font-size: 18px;
            text-align: center;
        }
        .btn-home {
            display: block;
            margin: 20px auto;
            width: 150px;
            background-color: #337ab7;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            padding: 10px 0;
            text-align: center;
            text-decoration: none;
        }
        .btn-home:hover {
            background-color: #286090;
        }
        .invoice {
            margin-top: 30px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #f9f9f9;
        }
        .invoice-header {
            background-color: #337ab7;
            color: white;
            padding: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 20px;
            border-radius: 8px 8px 0 0;
        }
        .invoice-body {
            padding: 20px;
        }
        .invoice-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .invoice-label {
            font-weight: bold;
        }
    </style>
</head>
<body>
<!-- Navigation Header -->
<?php include('include/header.php'); ?>   
<div class="container">
    <h1>Order Confirmation</h1>
    <div class="message">
        <p>Thank you for your order!</p>
        <p>Your payment was successful.</p>
    </div>

    <?php if (isset($order)): ?>
        <div class="invoice">
            <div class="invoice-header">Invoice</div>
            <div class="invoice-body">
                <div class="invoice-row">
                    <div class="invoice-label">Order ID:</div>
                    <div><?php echo $order['order_id']; ?></div>
                </div>
                <div class="invoice-row">
                    <div class="invoice-label">Customer ID:</div>
                    <div><?php echo $order['customer_id']; ?></div>
                </div>
                <div class="invoice-row">
                    <div class="invoice-label">Cost:</div>
                    <div><?php echo $order['cost']; ?></div>
                </div>
                <div class="invoice-row">
                    <div class="invoice-label">Shipping Address:</div>
                    <div><?php echo $order['shipping_address']; ?></div>
                </div>
                <div class="invoice-row">
                    <div class="invoice-label">Billing Name:</div>
                    <div><?php echo $order['billing_name']; ?></div>
                </div>
                <div class="invoice-row">
                    <div class="invoice-label">Payment Status:</div>
                    <div><?php echo $order['payment_status']; ?></div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <a href="index.php" class="btn btn-home">Back to Home</a>
    <a href="dashboard.php" class="btn btn-home">Go to Dashboard</a>
    <a href="view_pdf.php" class="btn btn-home">Preview your website</a>
</div>

<!-- Navigation Footer -->
<?php include('include/footer.php'); ?>
</body>
</html>