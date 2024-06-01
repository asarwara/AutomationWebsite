<?php
// Include database connection
include '../config/db_connect.php';

// Initialize session
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and bind statement
    $stmt = $conn->prepare("SELECT id, password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows == 1) {
        // Fetch user data
        $row = $result->fetch_assoc();
        $admin_id = $row['id'];
        $hashed_password = $row['password'];

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, set session variables
            $_SESSION['admin_id'] = $admin_id;
            $_SESSION['admin_username'] = $username;
            header("Location: admin_dashboard.php");
            exit();
        } else {
            // Password is incorrect
            $_SESSION['error_message'] = "Invalid username or password.";
            header("Location: admin_login.php");
            exit();
        }
    } else {
        // User does not exist
        $_SESSION['error_message'] = "Invalid username or password.";
        header("Location: admin_login.php");
        exit();
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
