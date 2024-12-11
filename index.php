<?php
$conn = new mysqli ('localhost', 'root', 'zarc123', 'quiz_app');
if ($conn -> connect_error){
    die("connection failed". $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .question {
            margin-bottom: 20px;
        }
        .result {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Quiz App</h1>
    
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Process quiz submission
        $score = 0;
        $total_questions = 0;

        foreach ($_POST as $question_id => $selected_option) {
            $question_id = intval($question_id);
            $selected_option = intval($selected_option);

            $query = $conn->prepare("SELECT correct_option FROM questions WHERE id = ?");
            $query->bind_param("i", $question_id);
            $query->execute();
            $query->bind_result($correct_option);
            $query->fetch();
            $query->close();

            if ($selected_option === $correct_option) {
                $score++;
            }
            $total_questions++;
        }

        echo "<div class='result'>Your score: $score / $total_questions</div>";
    }
$conn ->close();
?>
</body>
</html>