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
        echo "Parking slot reserved successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Parking Slots</title>
</head>
<body>
    <h2>Parking Slots</h2>
    <form method="post">
        Select Slot:
        <select name="slot_id" required>
            <?php while($slot = $slots->fetch_assoc()): ?>
                <option value="<?php echo $slot['slot_id']; ?>" <?php echo $slot['availability'] == 'booked' ? 'disabled' : ''; ?>>
                    Slot <?php echo $slot['slot_number']; ?> (<?php echo $slot['availability']; ?>)
                </option>
            <?php endwhile; ?>
        </select><br>
        <button type="submit">Reserve Slot</button>
    </form>
</body>
</html>
