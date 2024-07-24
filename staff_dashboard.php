<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] != "staff") {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
head>
    <title>Staff Dashboard</title>
</head>
<body>
    <h2>Welcome, Staff</h2>
    <a href="logout.php">Logout</a>
    <h3>View Reservations</h3>
    <!-- Add functionality to view and manage reservations -->
</body>
</html>
