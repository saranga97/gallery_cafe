<?php
session_start();
include('config.php');

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];
    $name = $_POST["name"];
    $contact_no = $_POST["contact_no"];
    $email = $_POST["email"];
    $reservation_date = $_POST["reservation_date"];
    $reservation_time = $_POST["reservation_time"];
    $preferred_food = $_POST["preferred_food"];
    $occasion = $_POST["occasion"];
    $table_number = $_POST["table_number"];
    $status = 'pending';

    $sql = "INSERT INTO reservations (user_id, name, contact_no, email, reservation_date, reservation_time, preferred_food, occasion, status, table_number) 
            VALUES ('$user_id', '$name', '$contact_no', '$email', '$reservation_date', '$reservation_time', '$preferred_food', '$occasion', '$status', '$table_number')";

    if ($conn->query($sql) === TRUE) {
        $message = "Reservation submitted successfully! 
        And it is pending for approval";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Reservation</title>
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
                    <a class="nav-link" href="customer_dashboard.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view_menu_items.php">Menu Items</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="make_reservation.php">Table Reservations</a>
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
                    <a href="my_reservations.php">My Reservations</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div style="min-height: 85vh;" class="container content">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center">Reservations</h2>
                <h4 class="text-center">Booking Form</h4>
                <p class="text-center">Please fill out all required* fields. Thanks!</p>
                <form method="post" class="reservation-form">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="contact_no">Contact No:</label>
                            <input type="text" class="form-control" id="contact_no" name="contact_no" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="email">E-mail:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label for="table_number">Table Number:</label>
                            <input type="number" class="form-control" id="table_number" name="table_number" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="reservation_date">Date:</label>
                            <input type="date" class="form-control" id="reservation_date" name="reservation_date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="reservation_time">Time:</label>
                            <input type="time" class="form-control" id="reservation_time" name="reservation_time" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="preferred_food">Preferred Food:</label>
                            <select class="form-control" id="preferred_food" name="preferred_food" required>
                                <option value="" disabled selected>Select Food</option>
                                <option value="Indian">Indian</option>
                                <option value="Sri Lankan">Sri Lankan</option>
                                <option value="Korean">Korean</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="occasion">Occasion:</label>
                            <select class="form-control" id="occasion" name="occasion" required>
                                <option value="" disabled selected>Select Occasion</option>
                                <option value="Just Eating">Just Eating</option>
                                <option value="Party">Party</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-warning">Make Reservation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 The Gallery Cafe</p>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Reservation Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo $message; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            <?php if (!empty($message)) : ?>
                $('#messageModal').modal('show');
            <?php endif; ?>
        });
    </script>
</body>

</html>