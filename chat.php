<?php
session_start();

// Function to check if the user is authenticated
function isAuthenticated() {
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        return false;
    }
    $_SESSION['last_activity'] = time(); // update last activity time stamp
    return true;
}

// Redirect unauthenticated users to the login page
if (!isAuthenticated()) {
    http_response_code(401);
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatroom</title>
    <link rel="stylesheet" href="chat.css" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        var username = <?php echo json_encode($_SESSION['username']); ?>;
    </script>
</head>
<body>
    <header>
        <h1>A Simple Chatroom Service</h1>
    </header>
    <section id="chatwindow">
    <form action="login.php" method="GET">
    <input type="hidden" name="action" value="signout">
        <button id="logout-bttn" type="submit">Logout</button>
    </form>
        <div id="chatbox">
        </div>
        <form id="messageForm">
            <textarea id="messageInput" placeholder="Type your message here..."></textarea>
            <button type="submit" id="submit-bttn">Send</button>
        </form>
    </section>
    <script src="chat.js"></script>
</body>
</html>