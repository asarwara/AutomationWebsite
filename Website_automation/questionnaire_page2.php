<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
include('config/db_connect.php');

// Fetch questions and their prices from the database
$query = "SELECT * FROM questionnaire_question";
$result = mysqli_query($conn, $query);

// Check if there are any questions
if (mysqli_num_rows($result) > 0) {
    // Fetch questions and their prices and store them in an array
    $questions = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    // Divide questions into two parts
    $num_questions = count($questions);
    $questions_page2 = array_slice($questions, ceil($num_questions / 2)); // Second half of questions
} else {
    // Handle case where no questions are found
    $error_message = "No questions found in the database.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questionnaire Part 2</title>
    <link href="css/style.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
           .container-small {
            max-width: 600px;
            margin-top: 50px;
            margin-bottom: 50px;
            margin-left:25%;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .section-header {
            background-color: #337ab7;
            color: white;
            padding: 10px;
            margin-top: 20px;
        }
        .question-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .question-table td {
            padding: 5px;
        }
        .question-table input, .question-table textarea {
            width: 100%;
        }
    </style>
</head>
<!-- Navigation Header -->
<?php include('include/header.php'); ?>
<body>

<div class="container-small">
    <h1>Questionnaire Part 2</h1>
    <?php if (isset($error_message)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php else : ?>
        <form action="save_answers.php" method="post">
            <?php foreach ($questions_page2 as $question) : ?>
                <div class="section-header"><?php echo $question['question_text']; ?> (Price: $<?php echo $question['price']; ?>)</div>
                <div class="question-container">
                    <input type="text" name="question<?php echo $question['id']; ?>" class="form-control" required>
                </div>
            <?php endforeach; ?>

            <div class="section-header">Website Category</div>
<select name="website_category" class="form-control" required>
    <option value="" disabled selected>Select Website Category</option>
    <?php
    // Fetch categories from database
    $query = "SELECT * FROM categories";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        // Concatenate category name and price properly
        echo "<option value='" . $row['category_id'] . "'>" . $row['category_name'] . " (Price: $" . $row['price'] . ")</option>";
    }
    ?>
</select>
            <button type="submit" class="btn btn-primary mt-2 ">Submit</button>
        </form>
    <?php endif; ?>
</div>

<?php include('include/footer.php'); ?>
</body>
</html>
