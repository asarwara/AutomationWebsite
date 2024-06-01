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
    $questions_page1 = array_slice($questions, 0, ceil($num_questions / 2)); // First half of questions
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
    <title>Questionnaire Part 1</title>
    <link href="css/style.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container-small {
            max-width: 600px;
            margin-top: 50px;
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
<body>

<!-- Navigation Header -->
<?php include('include/header.php'); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="container-small">
            <h1>Questionnaire Part 1</h1>
            <?php if (isset($error_message)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error_message; ?>
                </div>
            <?php else : ?>
                <form action="questionnaire_page2.php" method="post">
                    <?php foreach ($questions_page1 as $question) : ?>
                        <div class="section-header"><?php echo $question['question_text']; ?> (Price: $<?php echo $question['price']; ?>)</div>
                        <table class="question-table">
                            <tr>
                                <td><input type="text" name="question<?php echo $question['id']; ?>" ></td>
                            </tr>
                        </table>
                    <?php endforeach; ?>

                    <button type="submit" class="btn btn-primary">Next</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include('include/footer.php'); ?>
</body>
</html>
