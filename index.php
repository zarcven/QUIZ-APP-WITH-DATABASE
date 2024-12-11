<?php
$conn = new mysqli('localhost', 'root', '', 'quiz_app');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
        .wrong {
            color: red;
        }
        .correct {
            color: green;
        }
    </style>
</head>
<body>
    <h1>Quiz App</h1>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $score = 0;
        $total_questions = 0;

        foreach ($_POST as $question_id => $selected_option) {
            $question_id = intval($question_id);
            $selected_option = intval($selected_option);

            $query = $conn->prepare("SELECT question, option1, option2, option3, option4, correct_option FROM questions WHERE id = ?");
            $query->bind_param("i", $question_id);
            $query->execute();
            $query->bind_result($question, $option1, $option2, $option3, $option4, $correct_option);
            $query->fetch();
            $query->close();

            if ($selected_option === $correct_option) {
                $score++;
            } else {
                echo "<div class='wrong'><p>Question: $question</p>";
                echo "<p>Your Answer: " . htmlspecialchars(${"option" . $selected_option}) . "</p>";
                echo "<p>Correct Answer: " . htmlspecialchars(${"option" . $correct_option}) . "</p></div>";
            }
            $total_questions++;
        }

        echo "<div class='result'>Your score: $score / $total_questions</div>";
    } else {
        $result = $conn->query("SELECT * FROM questions");
        if ($result->num_rows > 0) {
            echo "<form method='POST' action=''>";

            while ($row = $result->fetch_assoc()) {
                echo "<div class='question'>";
                echo "<p>" . htmlspecialchars($row['question']) . "</p>";
                for ($i = 1; $i <= 4; $i++) {
                    echo "<label>";
                    echo "<input type='radio' name='" . $row['id'] . "' value='" . $i . "' required> " . htmlspecialchars($row['option' . $i]) . "";
                    echo "</label><br>";
                }
                echo "</div>";
            }

            echo "<button type='submit'>Submit</button>";
            echo "</form>";
        } else {
            echo "<p>No questions available.</p>";
        }
    }

    $conn->close();
    ?>
</body>
</html>
