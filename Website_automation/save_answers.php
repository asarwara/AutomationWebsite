<?php
session_start(); // Start the session

// Include the database connection file
include 'config/db_connect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $customer_id = $_POST['customer_id'];
    $cost = $_POST['cost'];
    $shipping_address = $_POST['shipping_address'];
    $billing_name = $_POST['billing_name'];
    $_SESSION['billing_name'] = $billing_name; // Store billing name in session
    
    // Payment status
    $payment_status = "success";

    // Prepare an SQL statement
    $query = "INSERT INTO orders (customer_id, cost, shipping_address, billing_name, payment_status) 
              VALUES (?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $query);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "idsss", $customer_id, $cost, $shipping_address, $billing_name, $payment_status);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($conn);

        header("Location: orderconfirmation.php");
        exit;
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
} else {
    // If form is not submitted, redirect to payment page
    header("Location: payment.php");
    exit;
}
?>