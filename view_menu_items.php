<?php
session_start();
include('config.php');

$cousin_type = isset($_GET['cousin_type']) ? $_GET['cousin_type'] : '';

$sql = "SELECT * FROM menu_items";
if ($cousin_type) {
    $sql .= " WHERE cousin_type = '$cousin_type'";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Items</title>
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

    <style>
        .card {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
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
                <a class="nav-link" href="customer_dashboard.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="view_menu_items.php">Menu Items</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="make_reservation.php">Table Reservations</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="pre_order.php">Pre-order</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Parking.php">Parking</a>
            </li>
        </ul>
        <div class="dropdown">
            <button class="dropbtn"><?php echo isset($_SESSION["username"]) ? $_SESSION["username"] : 'User'; ?>
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content">
                <a href="account_settings.php">Account Settings</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </div>
</nav>

<div style="min-height: 85vh;" class="container content">
    <div class="row">
        <div class="col-12">
            <h2 class="text-center">Menu Items</h2>
            <form method="get" class="form-inline mb-4 justify-content-center">
                <label for="cousin_type" class="mr-2">Search by Cousin Type:</label>
                <select class="form-control mr-2" id="cousin_type" name="cousin_type">
                    <option value="">All</option>
                    <option value="Sri Lankan" <?php if ($cousin_type == 'Sri Lankan') echo 'selected'; ?>>Sri Lankan</option>
                    <option value="Korean" <?php if ($cousin_type == 'Korean') echo 'selected'; ?>>Korean</option>
                    <option value="Italian" <?php if ($cousin_type == 'Italian') echo 'selected'; ?>>Italian</option>
                    <option value="Indian" <?php if ($cousin_type == 'Indian') echo 'selected'; ?>>Indian</option>
                </select>
                <button type="submit" class="btn btn-warning">Search</button>
            </form>
            <div class="row">
                <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div style="margin-bottom: 30px;" card mb-4">
                        <img src="uploads/<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo $row['item_name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['item_name']; ?></h5>
                            <p class="card-text"><?php echo $row['description']; ?></p>
                            <p class="card-text"><strong>Price:</strong> $<?php echo $row['price']; ?></p>
                            <p class="card-text"><strong>Availability:</strong> <?php echo $row['availability']; ?></p>
                            <p class="card-text"><strong>Cousin Type:</strong> <?php echo $row['cousin_type']; ?></p>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>

<div class="footer">
    <p>&copy; 2024 The Gallery Cafe</p>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
