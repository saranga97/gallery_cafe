<?php
session_start();
include('config.php');

if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] != "customer") {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $address = $_POST["address"];
    
    $sql = "UPDATE users SET name='$name', email='$email', username='$username', address='$address' WHERE user_id='$user_id'";
    
    if ($conn->query($sql) === TRUE) {
        $_SESSION["username"] = $username;
        echo "Account updated successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    $sql = "SELECT * FROM users WHERE user_id='$user_id'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Account Settings</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <div class="navbar">
        <div class="navbar-left">
            <a href="customer_dashboard.php">Dashboard</a>
            <a href="view_menu_items.php">View Menu Items</a>
            <a href="make_reservation.php">Make a Reservation</a>
            <a href="pre_order.php">Pre-order</a>
        </div>
        <div class="navbar-right">
            <div class="dropdown">
                <button class="dropbtn"><?php echo $_SESSION["username"]; ?> 
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="account_settings.php" class="active">Account Settings</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div> 
        </div>
    </div>

    <div class="content">
        <h2>Account Settings</h2>
        <form method="post">
            Name: <input type="text" name="name" value="<?php echo $user['name']; ?>" required><br>
            Email Address: <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br>
            Username: <input type="text" name="username" value="<?php echo $user['username']; ?>" required><br>
            Address: <textarea name="address" required><?php echo $user['address']; ?></textarea><br>
            <button type="submit">Update</button>
        </form>
    </div>

    <div class="footer">
        <p>&copy; 2024 The Gallery Café</p>
    </div>
</body>
</html>
