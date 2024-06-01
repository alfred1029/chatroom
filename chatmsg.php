<?php
session_start();

// Prevent direct access
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    http_response_code(401); // Unauthorized access
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    http_response_code(401);
    session_unset();
    session_destroy();
    header("Location: login.php");
    echo "Access denied. User not logged in.";
    exit;
}

if (!headers_sent()) {
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > 120) {
        http_response_code(401);
        session_unset();
        session_destroy();
        exit;
    }
}
else{
    // Headers already sent
    echo "<script type='text/javascript'>alert('Session timeout. Redirecting...');
    window.location.href='login.php';</script>";
    exit;
}

$conn = new mysqli("mydb", "dummy", "c3322b", "db3322");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    // Insert message into the database
    $message = $conn->real_escape_string(trim($_POST['message']));
    $person = $_SESSION['username'];
    $time = time();

    $stmt = $conn->prepare("INSERT INTO `message` (time, message, person) VALUES (?, ?, ?)");
    $stmt->bind_param('iss', $time, $message, $person);
    $stmt->execute();
    echo $stmt->affected_rows > 0 ? "SUCCESS" : "ERROR";
    $stmt->close();
    // Set the last activity time stamp
    $_SESSION['last_activity'] = time();

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch messages from the database
    $oneHourAgo = time() - 3600;
    $stmt = $conn->prepare("SELECT message, person, time FROM `message` WHERE time >= ?");
    $stmt->bind_param('i', $oneHourAgo);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $row['formatted_time'] = date('H:i', $row['time'] + 8 * 3600);
        $messages[] = $row;
    }

    echo json_encode($messages);
    $stmt->close();
}

$conn->close();
?>