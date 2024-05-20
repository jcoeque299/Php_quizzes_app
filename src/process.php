<?php
require_once 'Quiz.php';

echo "<script>
        window.localStorage.clear()
      </script>";

$shouldRetake = isset($_GET['retake']) && $_GET['retake'] === 'true';

if ($_SERVER["REQUEST_METHOD"] == "POST" || $shouldRetake) {
    $questions = array("q1", "q2", "q3", "q4", "q5", "q6", "q7", "q8", "q9", "q10");
    $missingAnswers = array();

    foreach ($questions as $question) {
        if (empty($_POST[$question])) {
            $missingAnswers[] = $question;
        }
    }

    if (!empty($missingAnswers)) {
        echo "<script>
                window.localStorage.setItem('unansweredQuestions', JSON.stringify(" . json_encode($missingAnswers) . "))
                window.location.href = 'index.php?results=false'
              </script>";
        exit();
    } else {
        $quiz = new Quiz();

        $quiz->addQuestion("What does PHP stand for?", "b");
        $quiz->addQuestion("What is the result of the following code snippet? \$x = 5; echo ++\$x + \$x++;", "c");
        $quiz->addQuestion("How do you declare a static method in a PHP class?", "a");
        $quiz->addQuestion("What is the purpose of the PHP function `htmlspecialchars()`?", "a");
        $quiz->addQuestion("How can you initiate a session in PHP?", "b");
        $quiz->addQuestion("What is the purpose of the `implode()` function in PHP?", "b");
        $quiz->addQuestion("In PHP, what is the difference between `==` and `===`?", "a");
        $quiz->addQuestion("How can you prevent SQL injection in PHP?", "c");
        $quiz->addQuestion("What is the purpose of the `unset()` function in PHP?", "b");
        $quiz->addQuestion("How can you include an external PHP file?", "c");

        $userAnswers = $_POST;
        $results = array();

        foreach ($questions as $index => $question) {
            $questionKey = "q" . ($index + 1);

            if (isset($userAnswers[$questionKey]) && $userAnswers[$questionKey] == $quiz->getCorrectAnswer($index)) {
                $result = "Correct!";
            } else {
                $result = "Incorrect. Correct answer: " . $quiz->getCorrectAnswer($index);
            }

            $results[$questionKey] = $result;
        }

        echo "<script>
                window.localStorage.setItem('quizResults', JSON.stringify(" . json_encode($results) . "))
                window.location.href = 'index.php?results=true'
              </script>";
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}