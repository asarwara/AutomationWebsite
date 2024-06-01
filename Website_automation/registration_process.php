<?php
// Include database connection
include 'config/db_connect.php';

// Initialize session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $address = trim($_POST['address']);

    // Validate that all fields are not empty
    if (empty($name) || empty($email) || empty($phone) || empty($password) || empty($confirm_password) || empty($address)) {
        $_SESSION['error_message'] = "All fields are required.";
        header("Location: registration.php");
        exit();
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        $_SESSION['error_message'] = "Passwords do not match.";
        header("Location: registration.php");
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM customer WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['error_message'] = "Email already exists. Please choose another one.";
        header("Location: registration.php");
        exit();
    }
    $stmt->close();

    // Prepare and bind statement
    $stmt = $conn->prepare("INSERT INTO customer (name, email, phone, password, address) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $phone, $hashed_password, $address);

    // Execute the statement
    if ($stmt->execute()) {
        // Registration successful
        $_SESSION['success_message'] = "Registration successful. You can now login.";
        header("Location: login.php");
        exit();
    } else {
        // Registration failed
        $_SESSION['error_message'] = "Registration failed. Please try again later.";
        header("Location: registration.php");
        exit();
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
