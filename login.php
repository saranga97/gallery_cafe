<?php
session_start();
include('config.php');

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["user_type"] = $row["user_type"];

            $response['status'] = 'success';
            $response['user_type'] = $row["user_type"];
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Invalid password.';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'No user found.';
    }
}

echo json_encode($response);
?>
