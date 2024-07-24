<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] != "admin") {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Welcome, Admin</h2>
    <a href="logout.php">Logout</a>
    <h3>Manage Menu Items</h3>
    <a href="add_menu_item.php">Add Menu Item</a>
    <h3>Manage Reservations</h3>
    <!-- Add functionality to manage reservations -->
</body>
</html>
