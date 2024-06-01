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

// Initialize variables
$questionText = $price = '';
$questionId = $_GET['id'] ?? null;

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $questionId = $_POST['question_id'];
    $questionText = $_POST['question_text'];
    $price = $_POST['price'];

    // Prepare and execute query to update question details
    $query = "UPDATE questionnaire_question SET question_text = ?, price = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sdi", $questionText, $price, $questionId);
    $stmt->execute();

    // Redirect back to the question list
    header("Location: question_list.php");
    exit();
}

// Check if question ID is provided in the URL
if ($questionId !== null) {
    // Retrieve question details based on the provided question ID
    $query = "SELECT question_text, price FROM questionnaire_question WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $questionId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if question exists
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $questionText = $row['question_text'];
        $price = $row['price'];
    } else {
        // Redirect to question list or display an error message
        header("Location: question_list.php");
        exit();
    }
} else {
    // Redirect to question list or display an error message
    header("Location: question_list.php");
    exit();
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

.container {
            margin-top: 50px;
        }

        /* Style form elements */
        form {
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            font-weight: bold;
        }

        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical; /* Allow vertical resizing */
        }

        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; /* Include padding and border in element's total width and height */
        }

        button[type="submit"] {
            background-color: #007bff; /* Blue */
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        button[type="submit"]:hover {
            background-color: #0056b3; /* Darker blue */
        }
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
    <h1 class="text-center">Modify Question</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="question_id" value="<?php echo $questionId; ?>">
        <div class="form-group">
            <label for="question_text">Question Text:</label>
            <textarea class="form-control" name="question_text" id="question_text" rows="4"><?php echo $questionText; ?></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" class="form-control" name="price" id="price" value="<?php echo $price; ?>" step="0.01" min="0">
        </div>
        <button type="submit" class="btn btn-primary btn-block">Submit</button>
    </form>
</div>


<?php include('../include/footer.php'); ?>
</body>
</html>