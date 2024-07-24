<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $cuisine_type = $_POST["cuisine_type"];

    $sql = "INSERT INTO menu_items (name, description, price, cuisine_type) VALUES ('$name', '$description', '$price', '$cuisine_type')";

    if ($conn->query($sql) === TRUE) {
        echo "Menu item added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Menu Item</title>
</head>
<body>
    <h2>Add Menu Item</h2>
    <form method="post">
        Name: <input type="text" name="name" required><br>
        Description: <textarea name="description" required></textarea><br>
        Price: <input type="number" name="price" step="0.01" required><br>
        Cuisine Type: 
        <select name="cuisine_type" required>
            <option value="Sri Lankan">Sri Lankan</option>
            <option value="Chinese">Chinese</option>
            <option value="Italian">Italian</option>
            <option value="Indian">Indian</option>
        </select><br>
        <button type="submit">Add</button>
    </form>
</body>
</html>
