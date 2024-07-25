<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] != "staff") {
    header("Location: login.php");
    exit();
}
include('config.php');

// Fetch reservations
$reservations = $conn->query("SELECT * FROM reservations ORDER BY reservation_date DESC, reservation_time DESC");

// Fetch pre-orders
$pre_orders = $conn->query("SELECT pre_orders.*, menu_items.item_name FROM pre_orders 
                            JOIN menu_items ON pre_orders.menu_item_id = menu_items.item_id
                            ORDER BY pre_orders.order_time DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="js/scripts.js" defer></script>
    <style>
        .table-responsive {
            overflow-x: auto;
        }

        .table thead th,
        .table tbody td {
            font-size: 0.8rem;
            white-space: nowrap;
        }

        .modal-backdrop {
            position: unset;
        }

        .navbar {
            background-color: #333;
        }

        .navbar-brand, .nav-link {
            color: #fff !important;
        }

        .dropdown .dropbtn {
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .dropdown .dropbtn:hover,
        .dropdown .dropbtn:focus {
            background-color: #555;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: #fff;
            margin-top: 20px;
        }
    </style>
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
                    <a class="nav-link active" href="staff_dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="staff_manage_reservations.php">Manage Reservations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="staff_manage_pre_orders.php">Manage Pre-Orders</a>
                </li>
            </ul>
            <div class="dropdown">
                <button class="dropbtn"><?php echo isset($_SESSION["username"]) ? $_SESSION["username"] : 'User'; ?>
                    <i class="fa fa-caret-down"></i>
                </button>
                <div style="margin-right: 90px;" class="dropdown-content">
                    <a href="staff_account_settings.php">Account Settings</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div style="min-height: 85vh;" class="container mt-5">
        <h2 class="text-center">Welcome, Staff</h2>
        <div class="row">
            <div class="col-16 mt-5">
                <h3>Manage Reservations</h3>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Contact No</th>
                                <th>Email</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Preferred Food</th>
                                <th>Occasion</th>
                                <th>Table Number</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $reservations->fetch_assoc()) : ?>
                                <tr>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['contact_no']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['reservation_date']; ?></td>
                                    <td><?php echo $row['reservation_time']; ?></td>
                                    <td><?php echo $row['preferred_food']; ?></td>
                                    <td><?php echo $row['occasion']; ?></td>
                                    <td><?php echo $row['table_number']; ?></td>
                                    <td><?php echo $row['status']; ?></td>
                                    <td>
                                        <button class="btn btn-warning edit-reservation" data-id="<?php echo $row['reservation_id']; ?>">Edit</button>
                                        <button class="btn btn-danger delete-reservation" data-id="<?php echo $row['reservation_id']; ?>">Delete</button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div style="margin-left: auto; margin-right:auto" class="col-12 mt-5 ml-auto mr-auto">
                <h3>Manage Pre-Orders</h3>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Quantity</th>
                                <th>Order Time</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $pre_orders->fetch_assoc()) : ?>
                                <tr>
                                    <td><?php echo $row['item_name']; ?></td>
                                    <td><?php echo $row['quantity']; ?></td>
                                    <td><?php echo $row['order_time']; ?></td>
                                    <td><?php echo $row['status']; ?></td>
                                    <td>
                                        <button class="btn btn-warning edit-pre-order" data-id="<?php echo $row['order_id']; ?>">Edit</button>
                                        <button class="btn btn-danger delete-pre-order" data-id="<?php echo $row['order_id']; ?>">Delete</button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 The Gallery Cafe</p>
    </div>

    <!-- Confirmation Modals and Success Modals will go here -->

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Edit and Delete functionality for Reservations and Pre-Orders will go here
        });
    </script>
</body>

</html>
