<?php

$db_conn = mysqli_connect("mydb", "dummy", "c3322b", "db3322");

if (isset($_GET['email'])) {
    $email = mysqli_real_escape_string($db_conn, $_GET['email']);
    $query = "SELECT useremail FROM account WHERE useremail = ?";
    $stmt = $db_conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "exists";
    } else {
        echo "not_exists";
    }
    $stmt->close();
}
mysqli_close($db_conn);
?>