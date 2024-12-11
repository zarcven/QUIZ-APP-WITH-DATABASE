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
</body>
</html>