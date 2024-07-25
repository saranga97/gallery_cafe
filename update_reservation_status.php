<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reservation_id = $_POST['reservation_id'];
    $status = $_POST['status'];

    $sql = "UPDATE reservations SET status='$status' WHERE reservation_id='$reservation_id'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Success";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
