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
        echo "<script>alert('Account updated successfully!');</script>";
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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="js/scripts.js" defer></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">The Gallery Café</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="customer_dashboard.php">Home</a>
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
                    <a class="nav-link active" href="parking.php">Parking</a>
                </li>
                
            </ul>
            <div class="dropdown">
                <button class="dropbtn"><?php echo isset($_SESSION["username"]) ? $_SESSION["username"] : 'User'; ?>
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="account_settings.php" class="active">Account Settings</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div style="min-height: 85vh;" class="container content">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center">Account Settings</h2>
                <form method="post" class="mt-4">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <textarea class="form-control" id="address" name="address" required><?php echo $user['address']; ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-warning">Update</button>
                </form>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 The Gallery Café</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
