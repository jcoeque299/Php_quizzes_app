<?php
    $servername = "db";
    $username = "root";
    $password = "pestillo";
    
    $conn = new mysqli($servername, $username, $password, "quizzes");  

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['update'])) {
        $question_id = $_POST['question_id'];
        $sql = "DELETE FROM questions WHERE question_id = $question_id";
        $conn->query($sql);
        echo "Question deleted successfully";
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
        $question_id = $_POST['question_id'];
        $question = $_POST['question_text'];
        $option_a = $_POST['option_a'];
        $option_b = $_POST['option_b'];
        $option_c = $_POST['option_c'];
        $correct_option = $_POST['correct_option'];
        $question_type = $_POST['question_type'];
        $question_details = $_POST['question_details'];
        $sql = "UPDATE questions SET question_text = '$question', option_a = '$option_a', option_b = '$option_b', option_c = '$option_c', correct_option = '$correct_option', question_type = '$question_type', question_details = '$question_details' WHERE question_id = $question_id";
        $conn->query($sql);
        echo "Question updated successfully";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="index.php">Home</a>
    <h1>Questions</h1>
    <table>
        <tr>
            <th>Delete</th>
            <th>Question ID</th>
            <th>Question</th>
            <th>Option A</th>
            <th>Option B</th>
            <th>Option C</th>
            <th>Correct Option</th>
            <th>Question type</th>
            <th>Question details</th>
            <th>Quiz ID</th>
        </tr>
        <?php
            $sql = "SELECT * FROM questions";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td>
                        <form action="delete_questions.php" method="post">
                            <input type="hidden" name="question_id" value="<?php echo $row['question_id']; ?>">
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                    <td><?php echo $row['question_id']; ?></td>
                    <td><?php echo $row['question_text']; ?></td>
                    <td><?php echo $row['option_a']; ?></td>
                    <td><?php echo $row['option_b']; ?></td>
                    <td><?php echo $row['option_c']; ?></td>
                    <td><?php echo $row['correct_option']; ?></td>
                    <td><?php echo $row['question_type']; ?></td>
                    <td><?php echo $row['question_details']; ?></td>
                    <td><?php echo $row['quiz_id']; ?></td>
                <?php }
            }
        ?>
    </table>
    <style>
        table {
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
    </style>
    <form action="delete_questions.php" method="post">
        <label for="question_id">Question ID</label>
        <input type="text" name="question_id" id="question_id">
        <br>
        <label for="question">Question</label>
        <input type="text" name="question_text" id="question_text">
        <br>
        <label for="option_a">Option A</label>
        <input type="text" name="option_a" id="option_a">
        <br>
        <label for="option_b">Option B</label>
        <input type="text" name="option_b" id="option_b">
        <br>
        <label for="option_c">Option C</label>
        <input type="text" name="option_c" id="option_c">
        <br>
        <label for="correct_option">Correct Option</label>
        <input type="text" name="correct_option" id="correct_option">
        <br>
        <input type="hidden" name="update" value="update">
        <input type="submit" value="Submit">
    </form>
</body>
</html>

<?php
    $conn->close();
?>