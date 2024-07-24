<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];
    $menu_item_id = $_POST["menu_item_id"];
    $quantity = $_POST["quantity"];
    $order_time = date('Y-m-d H:i:s');

    $sql = "INSERT INTO pre_orders (user_id, menu_item_id, quantity, order_time) VALUES ('$user_id', '$menu_item_id', '$quantity', '$order_time')";

    if ($conn->query($sql) === TRUE) {
        echo "Pre-order placed successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$menu_items = $conn->query("SELECT * FROM menu_items");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pre-order Food</title>
</head>
<body>
    <h2>Pre-order Food</h2>
    <form method="post">
        Menu Item:
        <select name="menu_item_id" required>
            <?php while($item = $menu_items->fetch_assoc()): ?>
                <option value="<?php echo $item['menu_item_id']; ?>"><?php echo $item['name']; ?></option>
            <?php endwhile; ?>
        </select><br>
        Quantity: <input type="number" name="quantity" required><br>
        <button type="submit">Place Order</button>
    </form>
</body>
</html>
