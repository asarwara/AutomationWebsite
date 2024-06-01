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
    .question-list-container {
        width: 80%; /* Adjust the width as needed */
        margin: 20px auto; /* Center the container */
    }

    .question-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .question-table th,
    .question-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .question-table th {
        background-color: #f2f2f2;
    }

    .modify-link {
        text-decoration: none;
        color: blue;
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



<div class="question-list-container">
    <h2>Question List</h2>

    <table class="question-table">
        <thead>
            <tr>
                <th>Question</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Retrieve all questions from the database
            $query = "SELECT id, question_text, price FROM questionnaire_question";
            $result = $conn->query($query);

            // Check if there are questions
            if ($result->num_rows > 0) {
                // Output question list
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['question_text'] . "</td>";
                    echo "<td>$" . $row['price'] . "</td>";
                    echo "<td><a href='change_questions.php?id=" . $row['id'] . "' class='modify-link'>Modify</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No questions found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
// HTML footer
include '../include/footer.php';
?>
