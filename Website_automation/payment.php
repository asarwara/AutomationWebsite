<?php
// Include the database connection file
include 'config/db_connect.php';

// Initialize session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to the login page
    $_SESSION['error_message'] = "Please log in to access the payment page.";
    header("Location: login.php");
    exit();
}

// Get the logged-in user ID from the session
$customerId = $_SESSION['user_id'];

// Fetch the total price from the database for the given customer ID
$query = "SELECT total_price FROM user_total_costs WHERE user_id = ?";
if ($stmt = mysqli_prepare($conn, $query)) {
    mysqli_stmt_bind_param($stmt, "i", $customerId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $totalPrice);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}

// Check if the total price is retrieved successfully
if ($totalPrice !== null) {
    $costMessage = "<p class='cost-display'>Cost: $" . number_format($totalPrice, 2) . "</p>";
} else {
    $costMessage = "<p class='cost-display'>Error: Unable to fetch cost information for customer ID: $customerId.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <!-- Bootstrap CSS -->
    <link href="css/style.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .cost-display {
            margin-top: 20px;
            font-size: 18px;
            color: green;
            font-weight: bold;
        }
        body {
            font-family: "PT Serif", serif;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 20px 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            color: #337ab7;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ced4da;
            box-sizing: border-box;
            transition: border-color 0.3s ease-in-out;
        }

        .form-control:focus {
            border-color: #337ab7;
            outline: none;
            box-shadow: 0 0 5px rgba(51, 122, 183, 0.5);
        }

        button.btn {
            background-color: #337ab7;
            color: #ffffff;
            font-size: 16px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        button.btn:hover {
            background-color: #286090;
        }

        .cost-display {
            margin-top: 20px;
            font-size: 18px;
            color: green;
            font-weight: bold;
            text-align: center;
        }

        /* Media Queries for Responsive Design */
        @media (max-width: 767px) {
            .container {
                padding: 15px 20px;
            }
            
            .form-group {
                margin-bottom: 15px;
            }
            
            h1 {
                font-size: 24px;
            }
            
            .form-control {
                padding: 8px;
                font-size: 14px;
            }
            
            button.btn {
                font-size: 14px;
                padding: 8px 16px;
            }
            
            .cost-display {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
<!-- Navigation Header -->
<?php include('include/header.php'); ?>
<div class="container">
    <h1>Payment Page</h1>

    <!-- Payment form -->
    <form action="process_payment.php" method="post" onsubmit="return validateForm()">
        <input type="hidden" name="customer_id" value="<?php echo $customerId; ?>">
        <input type="hidden" name="cost" value="<?php echo number_format($totalPrice, 2); ?>">
        <!-- Add more hidden fields as needed -->

        <!-- Shipping address -->
        <div class="form-group">
            <label for="shipping_address">Shipping Address</label>
            <textarea class="form-control" id="shipping_address" name="shipping_address" required></textarea>
        </div>

        <!-- Billing name -->
        <div class="form-group">
            <label for="billing_name">Billing Name</label>
            <input type="text" class="form-control" id="billing_name" name="billing_name" required>
        </div>

        <!-- Payment status -->
        <input type="hidden" name="payment_status" value="Paid">

        <!-- Payment details -->
        <div class="form-group">
            <label for="card_number">Card Number</label>
            <input type="text" class="form-control" id="card_number" name="card_number" required>
        </div>

        <div class="form-group">
            <label for="expiry_date">Expiry Date</label>
            <input type="text" class="form-control" id="expiry_date" name="expiry_date" placeholder="MM/YYYY" required>
        </div>

        <div class="form-group">
            <label for="cvv">CVV</label>
            <input type="text" class="form-control" id="cvv" name="cvv" required>
        </div>

        <!-- Payment button -->
        <button type="submit" class="btn btn-primary">Make Payment</button>
    </form>

    <!-- Cost display -->
    <?php echo $costMessage; ?>
</div>
<!-- Navigation Footer -->
<?php include('include/footer.php'); ?>

<script>
    function validateForm() {
        const cardNumber = document.getElementById('card_number').value;
        const expiryDate = document.getElementById('expiry_date').value;
        const cvv = document.getElementById('cvv').value;

        // Check if card number is 16 digits
        const cardNumberPattern = /^\d{16}$/;
        if (!cardNumberPattern.test(cardNumber)) {
            alert("Please enter a valid 16-digit card number.");
            return false;
        }

        // Check if expiry date is in MM/YYYY format and is a valid date
        const expiryDatePattern = /^(0[1-9]|1[0-2])\/\d{4}$/;
        if (!expiryDatePattern.test(expiryDate)) {
            alert("Please enter a valid expiry date in MM/YYYY format.");
            return false;
        }

        // Check if CVV is 3 or 4 digits
        const cvvPattern = /^\d{3,4}$/;
        if (!cvvPattern.test(cvv)) {
            alert("Please enter a valid CVV (3 or 4 digits).");
            return false;
        }

        return true;
    }
</script>
</body>
</html>
