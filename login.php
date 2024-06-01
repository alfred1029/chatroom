<?php
session_start();
// logout when the user clicks the logout button
if (isset($_GET['action']) && $_GET['action'] === 'signout') {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

$db_conn=mysqli_connect("mydb", "dummy", "c3322b", "db3322")
or die("Connection Error! ".mysqli_connect_error());

if (isset($_SESSION['loggedin'])) {
    header('Location: chat.php');
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST['type'] ?? '';
    $user = $_POST['user'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($type === 'login') {
        // Login logic
        $sql = "SELECT * FROM account WHERE useremail = ?";
        $stmt = $db_conn->prepare($sql);
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $account = $result->fetch_assoc();
            if ($account['password'] === $password) {
                // Set session variables
                // trim the email to remove @connect.hku.hk
                $session_duration = 120;
                $_SESSION["loggedin"] = true;
                $_SESSION['username'] = substr($account['useremail'], 0,-15);
                $_SESSION['last_activity'] = time();
                header("Location: chat.php");
                exit();
            }
            else {
                $message = "Failed to login. Incorrect password!!";
            }
        }
        // Wrong username
        else {
            $message = "Failed to login. Unknown user!!";
        }

    } elseif ($type === 'register') {
        // Registration logic
        $sql = "SELECT * FROM account WHERE useremail = ?";
        $stmt = $db_conn->prepare($sql);
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $message = "Failed to register. User already exists!!";
        }
        else {
            $sql = "INSERT INTO account (useremail, password) VALUES (?, ?)";
            $stmt = $db_conn->prepare($sql);
            $stmt->bind_param("ss", $user, $password);
            $stmt->execute();
            $session_duration = 120;
            $_SESSION["loggedin"] = true;
            $_SESSION['username'] = substr($user, 0,-15);
            $_SESSION['last_activity'] = time();
            header("Location: chat.php");
            exit();
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>COMP3322 Assignment 3 WongWaiChung</title>
    <link rel="stylesheet" type="text/css" href="login.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <header>
        <h1>A Simple Chatroom Service</h1>
    </header>
    <div id="container">
    <div id="login-form">
        <h2>Login to Chatroom</h2>
        <form action="login.php" method="POST">
            <fieldset name="logininfo">
            <legend>Login</legend>
            <label for="user">Email:</label>
            <input type="text" name="user" id="user" pattern="[a-z0-9._%+\-]+@connect.hku.hk" required><br><br>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br><br>
            <input type="submit" class="bttn" id="login-bttn" name="type" value="login">
            </fieldset>
        </form>
        <p>Click <a href="#" id="to-register-form">here</a> to register an account</p>
        <p class="alert" id="login-alert"></p>
    </div>
    <div id="register-form">
        <h2>Register an Account</h2>
        <form action="login.php" method="POST">
            <fieldset name="registerinfo">
            <legend>Register</legend>
            <label for="new-user">Email:</label>
            <input type="text" name="user" id="new-user" pattern="[a-z0-9._%+\-]+@connect.hku.hk" required><br><br>
            <label for="new-password">Password:</label>
            <input type="password" name="password" id="new-password" required><br><br>
            <label for="confirm-password">Confirm:</label>
            <input type="password" id="confirm-password" required><br><br>
            <input type="submit" class="bttn" id="register-bttn" name="type" value="register">
            </fieldset>
        </form>
        <p>Click <a href="#" id="to-login-form">here</a> for login</p>
        <p class="alert" id="register-alert"></p>
    </div>
    </div>
    <script>
        $(document).ready(function() {
            <?php if (!empty($message)): ?>
            $('#login-alert').text('<?php echo $message; ?>');
            <?php endif; ?>
        });
    </script>
    <script src="login.js"></script>
</body>
</html>