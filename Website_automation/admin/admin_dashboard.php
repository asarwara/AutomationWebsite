<?php
// Start the session
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Include database connection
include '../config/db_connect.php';

// Define variables to hold table data
$orderTableData = '';
$customerTableData = '';
$enquiryTableData = ''; // New variable for enquiry table data

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the "Show Customer Table" button is clicked
    if (isset($_POST['show_customer_table'])) {
        // Fetch customer table data
        $customerTableData = fetchCustomerTableData();
    }

    // Check if the "Show Order Table" button is clicked
    if (isset($_POST['show_order_table'])) {
        // Fetch order table data
        $orderTableData = fetchOrderTableData();
    }

    // Check if the "Show Enquiry Table" button is clicked
    if (isset($_POST['show_enquiry_table'])) {
        // Fetch enquiry table data
        $enquiryTableData = fetchEnquiryTableData();
    }

    // Check if the "Change Questions" button is clicked
    if (isset($_POST['change_questions'])) {
        // Redirect to change_questions.php
        header("Location: change_questions.php");
        exit();
    }
}

// Function to fetch customer table data
function fetchCustomerTableData() {
    global $conn;
    $sql = "SELECT * FROM customer";
    $result = mysqli_query($conn, $sql);
    $customerTableData = '';
    if (mysqli_num_rows($result) > 0) {
        // Display customer table
        $customerTableData .= '<table border="1">';
        $customerTableData .= '<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th></tr>';
        while ($row = mysqli_fetch_assoc($result)) {
            $customerTableData .= '<tr>';
            $customerTableData .= '<td>' . $row["id"] . '</td>';
            $customerTableData .= '<td>' . $row["name"] . '</td>';
            $customerTableData .= '<td>' . $row["email"] . '</td>';
            $customerTableData .= '<td>' . $row["phone"] . '</td>';
            $customerTableData .= '</tr>';
        }
        $customerTableData .= '</table>';
    } else {
        $customerTableData = "No customers found.";
    }
    return $customerTableData;
}

// Function to fetch order table data
function fetchOrderTableData() {
    global $conn;
    $sql = "SELECT * FROM orders";
    $result = mysqli_query($conn, $sql);
    $orderTableData = '';
    if (mysqli_num_rows($result) > 0) {
        // Display order table
        $orderTableData .= '<table border="1">';
        $orderTableData .= '<tr><th>Order ID</th><th>Customer ID</th><th>Cost</th></tr>';
        while ($row = mysqli_fetch_assoc($result)) {
            $orderTableData .= '<tr>';
            $orderTableData .= '<td>' . $row["order_id"] . '</td>';
            $orderTableData .= '<td>' . $row["customer_id"] . '</td>';
            $orderTableData .= '<td>' . $row["cost"] . '</td>';
            $orderTableData .= '</tr>';
        }
        $orderTableData .= '</table>';
    } else {
        $orderTableData = "No orders found.";
    }
    return $orderTableData;
}

// Function to fetch enquiry table data
function fetchEnquiryTableData() {
    global $conn;
    $sql = "SELECT * FROM enquiry";
    $result = mysqli_query($conn, $sql);
    $enquiryTableData = '';
    if (mysqli_num_rows($result) > 0) {
        // Display enquiry table
        $enquiryTableData .= '<table border="1">';
        $enquiryTableData .= '<tr><th>ID</th><th>Name</th><th>Email</th><th>Subject</th><th>Message</th><th>Created At</th></tr>';
        while ($row = mysqli_fetch_assoc($result)) {
            $enquiryTableData .= '<tr>';
            $enquiryTableData .= '<td>' . $row["id"] . '</td>';
            $enquiryTableData .= '<td>' . $row["name"] . '</td>';
            $enquiryTableData .= '<td>' . $row["email"] . '</td>';
            $enquiryTableData .= '<td>' . $row["subject"] . '</td>';
            $enquiryTableData .= '<td>' . $row["message"] . '</td>';
            $enquiryTableData .= '<td>' . $row["created_at"] . '</td>';
            $enquiryTableData .= '</tr>';
        }
        $enquiryTableData .= '</table>';
    } else {
        $enquiryTableData = "No enquiries found.";
    }
    return $enquiryTableData;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<style>
    /* style.css */
/* Navbar */
.navbar {
    background-color: #3498db;
    color: #fff;
}

.navbar-brand {
    color: #fff;
}

.navbar-toggler-icon {
    background-color: #fff;
}

/* Page container */
.container {
    margin-top: 20px;
    margin-bottom: 20px;
}

/* Button styling */
.btn-primary {
    background-color: #3498db;
    border-color: #3498db;
}

.btn-primary:hover {
    background-color: #2980b9;
    border-color: #2980b9;
}

/* Table styling */
table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 20px;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}

/* Colorful table design */
tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:nth-child(odd) {
    background-color: #e6f7ff;
}

/* Footer */
/* footer {
    margin-top: 20px;
    text-align: center;
    color: #555;
} */

</style>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="admin_dashboard.php">Admin Panel</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">

          
        </ul>
        <?php if(isset($_SESSION['admin_id'])) { ?>
            <form class="form-inline my-2 my-lg-0" action="admin_logout.php" method="post">
                <button class="btn btn-outline-danger my-2 my-sm-0" type="submit" name="logout">Logout</button>
            </form>
        <?php } ?>
    </div>
</nav>


<div class="container">
    <h1>Welcome to Admin Dashboard</h1>
    
    <!-- Buttons for various actions -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <button type="submit" class="btn btn-primary" name="show_customer_table">Show Customer Table</button>
        <button type="submit" class="btn btn-primary" name="show_order_table">Show Order Table</button>
        <button type="submit" class="btn btn-primary" name="change_questions">Change Questions</button>
        <button type="submit" class="btn btn-primary" name="show_enquiry_table">Show enquiry</button>
    </form>
      <!-- Display customer table -->
    <div><?php echo $customerTableData; ?></div>
    
    <!-- Display order table -->
    <div><?php echo $orderTableData; ?></div>
        <!-- Display enquiry table -->
    <div><?php echo $enquiryTableData; ?></div>

</div>
<?php include('../include/footer.php'); ?>
</body>
</html>
