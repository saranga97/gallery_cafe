<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST["order_id"];
    $status = $_POST["status"];

    $sql = "UPDATE pre_orders SET status = '$status' WHERE order_id = '$order_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Pre-Order status updated successfully.";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
