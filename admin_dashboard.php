<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] != "admin") {
    header("Location: login.php");
    exit();
}
include('config.php');

// Fetch data for the charts
$users_data = $conn->query("SELECT DATE(created_at) as date, COUNT(*) as total_users FROM users GROUP BY DATE(created_at)");
$reservations_data = $conn->query("SELECT reservation_date, COUNT(*) as total_reservations FROM reservations GROUP BY reservation_date");
$pre_orders_data = $conn->query("SELECT DATE(order_time) as date, COUNT(*) as total_pre_orders FROM pre_orders GROUP BY DATE(order_time)");
$sales_data = $conn->query("SELECT menu_items.item_name, SUM(pre_orders.quantity) as total_sales FROM pre_orders JOIN menu_items ON pre_orders.menu_item_id = menu_items.item_id GROUP BY menu_items.item_name");

$menu_items_data = $conn->query("SELECT cousin_type, COUNT(*) as total_items FROM menu_items GROUP BY cousin_type");

$menu_items_labels = [];
$menu_items_totals = [];
while ($row = $menu_items_data->fetch_assoc()) {
    $menu_items_labels[] = $row['cousin_type'];
    $menu_items_totals[] = $row['total_items'];
}

$users_dates = [];
$users_totals = [];
while ($row = $users_data->fetch_assoc()) {
    $users_dates[] = $row['date'];
    $users_totals[] = $row['total_users'];
}

$reservations_dates = [];
$reservations_totals = [];
while ($row = $reservations_data->fetch_assoc()) {
    $reservations_dates[] = $row['reservation_date'];
    $reservations_totals[] = $row['total_reservations'];
}

$pre_orders_dates = [];
$pre_orders_totals = [];
while ($row = $pre_orders_data->fetch_assoc()) {
    $pre_orders_dates[] = $row['date'];
    $pre_orders_totals[] = $row['total_pre_orders'];
}

$sales_items = [];
$sales_totals = [];
while ($row = $sales_data->fetch_assoc()) {
    $sales_items[] = $row['item_name'];
    $sales_totals[] = $row['total_sales'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="js/scripts.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                    <a class="nav-link active" href="admin_dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_pre_orders.php">Manage Pre Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_reservations.php">Manage Table Reservations</a>
                </li>

            </ul>
            <div class="dropdown">
                <button class="dropbtn"><?php echo isset($_SESSION["username"]) ? $_SESSION["username"] : 'User'; ?>
                    <i class="fa fa-caret-down"></i>
                </button>
                <div style="margin-right: 90px;" class="dropdown-content">
                    <a href="account_settings.php">Account Settings</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div style="min-height: 85vh;" class="container mt-5">
        <h2 class="text-center">Welcome, Admin</h2>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Number of Users</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="usersChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Number of Reservations</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="reservationsChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Number of Pre-Orders</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="preOrdersChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Total Sales</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
            <div style="margin-left: auto; margin-right:auto" class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Menu Items Available</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="menuItemsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 The Gallery Cafe</p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Users Chart
            var ctxUsers = document.getElementById('usersChart').getContext('2d');
            var usersChart = new Chart(ctxUsers, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($users_dates); ?>,
                    datasets: [{
                        label: 'Number of Users',
                        data: <?php echo json_encode($users_totals); ?>,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    }
                }
            });

            // Reservations Chart
            var ctxReservations = document.getElementById('reservationsChart').getContext('2d');
            var reservationsChart = new Chart(ctxReservations, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($reservations_dates); ?>,
                    datasets: [{
                        label: 'Number of Reservations',
                        data: <?php echo json_encode($reservations_totals); ?>,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    }
                }
            });

            // Pre-Orders Chart
            var ctxPreOrders = document.getElementById('preOrdersChart').getContext('2d');
            var preOrdersChart = new Chart(ctxPreOrders, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($pre_orders_dates); ?>,
                    datasets: [{
                        label: 'Number of Pre-Orders',
                        data: <?php echo json_encode($pre_orders_totals); ?>,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    }
                }
            });

            // Sales Chart
            var ctxSales = document.getElementById('salesChart').getContext('2d');
            var salesChart = new Chart(ctxSales, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($sales_items); ?>,
                    datasets: [{
                        label: 'Total Sales',
                        data: <?php echo json_encode($sales_totals); ?>,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    }
                }
            });

            // Menu Items Chart
            var ctxMenuItems = document.getElementById('menuItemsChart').getContext('2d');
            var menuItemsChart = new Chart(ctxMenuItems, {
                type: 'pie',
                data: {
                    labels: <?php echo json_encode($menu_items_labels); ?>,
                    datasets: [{
                        label: 'Menu Items',
                        data: <?php echo json_encode($menu_items_totals); ?>,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>