CREATE DATABASE IF NOT EXISTS quizzes
USE quizzes

CREATE TABLE IF NOT EXISTS quiz
(
    quiz_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    quiz_user VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE TABLE IF NOT EXISTS questions
(
    question_id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT,
    question_text TEXT,
    option_a VARCHAR(255),
    option_b VARCHAR(255),
    option_c VARCHAR(255),
    correct_option CHAR(1),
    FOREIGN KEY (quiz_id) REFERENCES quiz(quiz_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

INSERT INTO quiz (title, description, quiz_user) VALUES
    ('PHP Quizzes tarea', 'hola', 'Judy');

INSERT INTO questions (quiz_id, question_text, option_a, option_b, option_c, correct_option) VALUES
    (1, 'What does PHP stand for?', 'Personal Home Page', 'PHP: Hypertext Preprocessor', 'PHP Hyper Markup Language', 'b'),
    (1, 'What is the result of the following code? $x = 5; echo ++$x + $x++;', '11', '12', '13', 'c'),
    (1, 'How do you declare a static method in a PHP class?', 'static function methodName() {}', 'function static methodName() {}', 'function methodName() static {}', 'a'),
    (1, 'What is the purpose of the PHP function `htmlspecialchars()`?', 'Converts special characters to HTML entities', 'Parses HTML code', 'Encodes URLs', 'a'),
    (1, 'How can you initiate a session in PHP?', 'start_session()', 'session_start()', 'init_session()', 'b'),
    (1, 'What is the purpose of the `implode()` function in PHP?', 'Splits a string into an array', 'Joins array elements into a string', 'Finds the length of a string', 'b'),
    (1, 'In PHP, what is the difference between `==` and `===`?', '`==` checks for value equality, `===` checks for value and type equality', '`==` checks for value and type equality, `===` checks for value equality', 'There is no difference', 'a'),
    (1, 'How can you prevent SQL injection in PHP?', 'Use prepared statements', 'Sanitize user input', 'Both a and b', 'c'),
    (1, 'What is the purpose of the `unset()` function in PHP?', 'Deletes a file', 'Unsets a variable', 'Removes an array element', 'b'),
    (1, 'How can you include an external PHP file?', 'include("file.php")', 'require("file.php")', 'Both a and b', 'c');
