<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] != "admin") {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="js/scripts.js" defer></script>

    <!-- Site Icons -->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png" />

    <!-- color -->
    <link id="changeable-colors" rel="stylesheet" href="css/colors/orange.css" />

    <!-- Modernizer -->
    <script src="js/modernizer.js"></script>
</head>

<body>
    <div class="navbar">
        <div class="navbar-left">
            <a href="admin_dashboard.php" class="active">Dashboard</a>
            <a href="manage_menu_items.php">Manage Menu Items</a>
            <a href="manage_reservations.php">Manage Reservations</a>
        </div>
        <div class="navbar-right">
            <div class="dropdown">
                <button class="dropbtn"><?php echo $_SESSION["username"]; ?>
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="account_settings.php">Account Settings</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <div style="min-height: 85vh;" class="container mt-5">
        <h2 class="text-center">Welcome, Admin</h2>
        <div class="row">
            <div class="col-md-4">
                <h3>Manage Menu Items</h3>
                <a href="add_menu_item.php" class="btn btn-primary">Add Menu Item</a>
            </div>
            <div class="col-md-4">
                <h3>Manage Reservations</h3>
                <!-- Add links and functionalities to manage reservations -->
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 The Gallery Cafe</p>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>

</html>