<?php
session_start();
include('config.php');

$slots = $conn->query("SELECT * FROM parking_slots");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];
    $slot_id = $_POST["slot_id"];
    $reservation_time = date('Y-m-d H:i:s');

    $sql = "INSERT INTO parking_reservations (user_id, slot_id, reservation_time) VALUES ('$user_id', '$slot_id', '$reservation_time')";
    $update_slot = "UPDATE parking_slots SET availability = 'booked' WHERE slot_id = '$slot_id'";

    if ($conn->query($sql) === TRUE && $conn->query($update_slot) === TRUE) {
        echo "<script>alert('Parking slot reserved successfully!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Slots</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="js/scripts.js" defer></script>
    <style>
        .parking-lot {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .slot {
            width: 100px;
            height: 100px;
            background-color: green;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            cursor: pointer;
        }

        .slot.booked {
            background-color: red;
            cursor: not-allowed;
        }

        .slot.selected {
            background-color: blue;
        }

        .btn-reserve {
            margin-top: 20px;
        }
    </style>
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
                    <a href="account_settings.php">Account Settings</a>
                    <a href="my_reservations.php">My Reservations</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div style="min-height:85vh;" class="container content">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center">Parking Slots</h2>
                <div class="parking-lot">
                    <?php while ($slot = $slots->fetch_assoc()): ?>
                    <div class="slot <?php echo $slot['availability'] == 'booked' ? 'booked' : 'available'; ?>" data-slot-id="<?php echo $slot['slot_id']; ?>">
                        Slot <?php echo $slot['slot_number']; ?><br>
                        (<?php echo $slot['availability']; ?>)
                    </div>
                    <?php endwhile; ?>
                </div>
                <form method="post" id="reserve-form">
                    <input type="hidden" name="slot_id" id="slot_id" required>
                    <button type="submit" class="btn btn-warning btn-reserve">Reserve Slot</button>
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
    <script>
        document.querySelectorAll('.slot').forEach(slot => {
            slot.addEventListener('click', function () {
                if (this.classList.contains('booked')) return;

                document.querySelectorAll('.slot').forEach(s => s.classList.remove('selected'));
                this.classList.add('selected');
                document.getElementById('slot_id').value = this.getAttribute('data-slot-id');
            });
        });
    </script>
</body>

</html>
