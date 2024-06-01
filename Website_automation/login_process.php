<?php
// Include database connection
include 'config/db_connect.php';

// Initialize session
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and bind statement
    $stmt = $conn->prepare("SELECT id, password FROM customer WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows == 1) {
        // Fetch user data
        $row = $result->fetch_assoc();
        $user_id = $row['id'];
        $hashed_password = $row['password'];

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['success_message'] = "Login successful. Welcome back!";
            header("Location: index.php");
            exit();
        } else {
            // Password is incorrect
            $_SESSION['error_message'] = "Invalid email or password.";
            header("Location: login.php");
            exit();
        }
    } else {
        // User does not exist
        $_SESSION['error_message'] = "Invalid email or password.";
        header("Location: login.php");
        exit();
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
