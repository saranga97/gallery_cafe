<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["proceed"])) {
    $user_id = $_SESSION["user_id"];
    $order_time = date('Y-m-d H:i:s');
    $status = 'pending';

    foreach ($_POST["cart"] as $cart_item) {
        $menu_item_id = $cart_item["menu_item_id"];
        $quantity = $cart_item["quantity"];
        $sql = "INSERT INTO pre_orders (user_id, menu_item_id, quantity, order_time, status) 
                VALUES ('$user_id', '$menu_item_id', '$quantity', '$order_time', '$status')";

        if (!$conn->query($sql) === TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    echo "<script>alert('Order placed successfully and is pending!');</script>";
}

$menu_items = $conn->query("SELECT * FROM menu_items");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pre-order Food</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="js/scripts.js" defer></script>
    <style>
        .card-horizontal {
            display: flex;
            flex: 1 1 auto;
        }

        .card-horizontal img {
            width: 150px;
            height: auto;
        }

        .add-to-cart {
            background-color: black;
            color: white;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }

        .add-to-cart:hover {
            background-color: #333;
            color: yellow;
        }

        .quantity-select {
            width: 80px;
            margin-left: 10px;
        }
    </style>
</head>

<body>
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
                    <a class="nav-link" href="make_reservation.php">Table Reservations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="pre_order.php">Pre-order</a>
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

    <div class="container content">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center">Pre-order Food</h2>
                <form method="post">
                    <div class="row">
                        <?php while ($item = $menu_items->fetch_assoc()): ?>
                        <div class="col-12 mb-4">
                            <div class="card card-horizontal">
                                <img src="uploads/<?php echo $item['image']; ?>" class="card-img-top" alt="<?php echo $item['item_name']; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $item['item_name']; ?></h5>
                                    <p class="card-text"><?php echo $item['description']; ?></p>
                                    <p class="card-text"><strong>Price:</strong> $<?php echo $item['price']; ?></p>
                                    <p class="card-text"><strong>Availability:</strong> <?php echo $item['availability']; ?></p>
                                    <p class="card-text"><strong>Cousin Type:</strong> <?php echo $item['cousin_type']; ?></p>
                                    <div>
                                        <label for="quantity_<?php echo $item['item_id']; ?>">Quantity:</label>
                                        <select class="quantity-select" id="quantity_<?php echo $item['item_id']; ?>">
                                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                        <input type="hidden" id="price_<?php echo $item['item_id']; ?>" value="<?php echo $item['price']; ?>">
                                        <button type="button" class="btn add-to-cart" onclick="addToCart(<?php echo $item['item_id']; ?>, '<?php echo $item['item_name']; ?>', <?php echo $item['price']; ?>)">Add to Cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                    <div class="text-right">
                        <h4>Total Value: $<span id="total_value">0.00</span></h4>
                        <button type="submit" name="proceed" class="btn btn-warning">Proceed</button>
                    </div>
                    <div id="cart_items"></div>
                </form>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 The Gallery Cafe</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        let cart = [];

        function addToCart(itemId, itemName, price) {
            const quantityElement = document.getElementById(`quantity_${itemId}`);
            const quantity = parseInt(quantityElement.value);
            const existingItem = cart.find(item => item.itemId === itemId);
            if (existingItem) {
                existingItem.quantity += quantity;
            } else {
                cart.push({ itemId, itemName, quantity: quantity, price: parseFloat(price) });
            }
            updateTotalValue();
            renderCartItems();
        }

        function updateTotalValue() {
            let total = 0;
            cart.forEach(item => {
                total += item.quantity * item.price;
            });
            document.getElementById('total_value').innerText = total.toFixed(2);
        }

        function renderCartItems() {
            const cartItemsDiv = document.getElementById('cart_items');
            cartItemsDiv.innerHTML = '';
            cart.forEach(item => {
                const inputMenuId = document.createElement('input');
                inputMenuId.type = 'hidden';
                inputMenuId.name = 'cart[' + item.itemId + '][menu_item_id]';
                inputMenuId.value = item.itemId;

                const inputQuantity = document.createElement('input');
                inputQuantity.type = 'hidden';
                inputQuantity.name = 'cart[' + item.itemId + '][quantity]';
                inputQuantity.value = item.quantity;

                cartItemsDiv.appendChild(inputMenuId);
                cartItemsDiv.appendChild(inputQuantity);
            });
        }
    </script>
</body>
</html>
