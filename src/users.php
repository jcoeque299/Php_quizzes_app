<?php
    session_start();
    $servername = "db";
    $username = "root";
    $password = "pestillo";
    
    $conn = new mysqli($servername, $username, $password, "quizzes"); 

    class User {
        public function check_form() {
            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                return false;
            }
            return true;
        }
        public function is_response_set($response) {
            if (!isset($_POST[$response])) {
                return false;
            }
            return $_POST[$response];
        }
        public function check_user($username, $password) {
            global $conn;
            $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                return true;
            }
            return false;
        }
        public function register_user($username, $password, $email) {
            global $conn;
            $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
            $result = $conn->query($sql);
            if ($result) {
                return true;
            }
            return false;
        }
    }
    $user = new User();
    
    if ($user->check_form() && isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if ($user->check_user($username, $password)) {
            $_SESSION['username'] = $username;
            echo "Login successful";
        } else {
            echo "Login failed";
        }
    }
    if ($user->check_form() && !isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        if ($user->register_user($username, $password, $email)) {
            $_SESSION['username'] = $username;
            echo "Register successful";
        } else {
            echo "Register failed";
        }
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
    <style>
        div {
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            width: 100%;
        }
        
        form {
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            width: 40%;
        }
    </style>
    <a href="index.php">Home</a>
    <div>
        <form action="users.php" method="post">
            <h1>Login</h1>
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="password" placeholder="Password">
            <input type="hidden" name="login" value="login">
            <input type="submit" value="Login">
        </form>
        <form action="users.php" method="post">
            <h1>Register</h1>
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="password" placeholder="Password">
            <input type="email" name="email" placeholder="Email">
            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>

<?php
    $conn->close();
?>