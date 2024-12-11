<?php
$conn = new mysqli ('localhost', 'root', 'zarc123', 'quiz_app');
if ($conn -> connect_error){
    die("connection failed". $conn->connect_error);
}