<?php
session_start();
// Include database connection
include 'config/db_connect.php';
include 'include/header.php';
echo "<h1>Your website looks like the following:</h1>";

// Check if a category has been selected
if (isset($_SESSION['user_id']) && isset($_SESSION['website_category'])) {
    $websiteCategory = $_SESSION['website_category'];
    $pdfPath = "category_pdf/" . $websiteCategory;
    // Retrieve the PDF path based on the stored website category
    $query = "SELECT pdf_path FROM categories WHERE category_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $websiteCategory);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the category exists and has a PDF associated with it
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $pdfPath = $row['pdf_path'];

        // Display the PDF viewer
        echo "<iframe src='$pdfPath' width='100%' height='800px' frameborder='0'></iframe>";

        // Add a button to redirect to the payment page
        echo "<form action='payment.php' method='post'>";
        echo "<input type='hidden' name='total_price' value=''>"; // Add total price here if needed
        echo "<button type='submit' class='btn btn-primary mb-3'>Proceed to Payment</button>";
        echo "</form>";
    } else {
        echo "PDF not found for the selected category.";
    }
} else {
    echo "User ID or website category not found in session.";
}

// Include footer
include 'include/footer.php';
?>