<?php
// Include database connection
include 'config/db_connect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Insert query
    $sql = "INSERT INTO enquiry (name, email, subject, message, created_at) VALUES ('$name', '$email', '$subject', '$message', NOW())";

    if (mysqli_query($conn, $sql)) {
        // Redirect to index.php
        header("Location: index.php");
        exit(); // Ensure script stops executing after redirection
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
}
?>
