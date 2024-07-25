<?php
session_start();
include('config.php');

if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] != "customer") {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Fetch table reservations
$table_reservations_sql = "SELECT * FROM reservations WHERE user_id='$user_id'";
$table_reservations_result = $conn->query($table_reservations_sql);

// Fetch pre-orders
$pre_orders_sql = "SELECT pre_orders.*, menu_items.item_name AS item_name FROM pre_orders 
                   JOIN menu_items ON pre_orders.menu_item_id = menu_items.item_id 
                   WHERE pre_orders.user_id='$user_id'";
$pre_orders_result = $conn->query($pre_orders_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Reservations</title>
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
<div id="loader">
        <div id="status"></div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">The Gallery Cafe</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="customer_dashboard.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view_menu_items.php">Menu Items</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="make_reservation.php">Table Reservations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pre_order.php">Pre-order</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pre_order.php">Parking</a>
                </li>
            </ul>
            <div class="dropdown">
                <button class="dropbtn"><?php echo isset($_SESSION["username"]) ? $_SESSION["username"] : 'User'; ?>
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="account_settings.php">Account Settings</a>
                    <a href="my_reservations.php">My Reservations</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">My Reservations</h2>

        <h3>Table Reservations</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Reservation ID</th>
                    <th>Table Number</th>
                    <th>Reservation Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($table_reservations_result->num_rows > 0): ?>
                    <?php while($row = $table_reservations_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['reservation_id']; ?></td>
                            <td><?php echo $row['table_number']; ?></td>
                            <td><?php echo $row['reservation_time']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No table reservations found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h3>Food Pre-orders</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Order Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($pre_orders_result->num_rows > 0): ?>
                    <?php while($row = $pre_orders_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['order_id']; ?></td>
                            <td><?php echo $row['item_name']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td><?php echo $row['order_time']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No food pre-orders found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>&copy; 2024 The Gallery Cafe</p>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
