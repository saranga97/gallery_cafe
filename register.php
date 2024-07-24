<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $address = $_POST["address"];
    $user_type = "customer"; // default user type for registration

    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (name, email, username, password, address, user_type) VALUES ('$name', '$email', '$username', '$hashed_password', '$address', '$user_type')";

        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";
            header("Location: login.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form method="post">
        Name: <input type="text" name="name" required><br>
        Email Address: <input type="email" name="email" required><br>
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        Confirm Password: <input type="password" name="confirm_password" required><br>
        Address: <textarea name="address" required></textarea><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
