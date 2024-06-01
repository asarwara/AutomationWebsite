
<?php
// Include database connection
include 'config/db_connect.php';

// Initialize session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // If user is not logged in, redirect to login page
    header("Location: login.php");
    exit();
}

// Fetch user data from database based on user ID
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM customer WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Update user profile in the database
    $update_stmt = $conn->prepare("UPDATE customer SET name = ?, email = ?, phone = ? WHERE id = ?");
    $update_stmt->bind_param("sssi", $name, $email, $phone, $user_id);
    
    if ($update_stmt->execute()) {
        // Profile update successful
        $_SESSION['success_message'] = "Profile updated successfully.";
        // Redirect to dashboard or profile page
        header("Location: dashbord.php");
        exit();
    } else {
        // Profile update failed
        $_SESSION['error_message'] = "Failed to update profile.";
    }

    // Close statement
    $update_stmt->close();
}

// Close connection
$conn->close();
?>
