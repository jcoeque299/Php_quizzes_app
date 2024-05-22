<?php
$servername = "db";
$username = "root";
$password = "pestillo";

$conn = new mysqli($servername, $username, $password, "quizzes"); 

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}