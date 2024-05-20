<?php
session_start();
require_once 'db.php';
$timerDuration = 5 * 60;

if (!isset($_SESSION['quiz_start_time']) || isset($_GET['restart'])) {
    $_SESSION['quiz_start_time'] = time();
    $quizId = 1;
    $sql = "SELECT * FROM questions WHERE quiz_id = $quizId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $questions = array();
        while ($row = $result->fetch_assoc()) {
            $questions[] = $row;
        }
    } else {
        die("No hay preguntas disponibles.");
    }
}

$elapsedTime = time() - $_SESSION['quiz_start_time'];
$remainingTime = max(0, $timerDuration - $elapsedTime);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['restart_timer'])) {
    $_SESSION['quiz_start_time'] = time();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Quiz</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <?php
        echo "<div class='timer'>" . gmdate("i:s", $remainingTime) . "</div>";
        echo "<form class='reset_timer' method='post' action='index.php'>
                <input type='hidden' name='restart_timer' value='1'>
                <input type='submit' value='Reset Time'>
              </form>"
    ?>
    <form method="post" action="process.php">
        <h1>PHP Quiz</h1>

        <?php
        foreach ($questions as $index => $question) {
            $questionKey = "q" . ($index + 1);
        ?>
        <div class="question">
            <p><?php echo ($index + 1) . '. ' . $question['question_text']; ?></p>
            <label><input type="radio" name="<?php echo $questionKey; ?>" value="a"> a) <?php echo $question['option_a']; ?></label>
            <label><input type="radio" name="<?php echo $questionKey; ?>" value="b"> b) <?php echo $question['option_b']; ?></label>
            <label><input type="radio" name="<?php echo $questionKey; ?>" value="c"> c) <?php echo $question['option_c']; ?></label>
            <div id="result_<?php echo $questionKey; ?>"></div>
        </div>
        <?php
        }
        ?>

        <input type="submit" value="Submit">
        <a href="index.php?retake=true" class="reset" onclick="resetLocalStorage()">Reset Quiz</a>
    </form>
</body>
<script>
    window.onload = function () {
        var unansweredQuestionsFromStorage = window.localStorage.getItem('unansweredQuestions')
        if (unansweredQuestionsFromStorage) {
            var unansweredQuestions = JSON.parse(unansweredQuestionsFromStorage)
            for (var i = 0; i < unansweredQuestions.length; i++) {
                var questionKey = unansweredQuestions[i];
                var resultContainer = document.getElementById("result_" + questionKey)
                if (resultContainer) {
                    resultContainer.innerHTML = "You must answer this question."
                }
            }
        } else {
            var resultsFromStorage = window.localStorage.getItem('quizResults')
            if (resultsFromStorage) {
                var results = JSON.parse(resultsFromStorage);
                for (var questionKey in results) {
                    var resultContainer = document.getElementById("result_" + questionKey);
                    if (resultContainer) {
                        resultContainer.innerHTML = results[questionKey]
                    }
                }
            }
        }
    }
    function resetLocalStorage() {
        window.localStorage.clear();
    }
</script>
</html>
