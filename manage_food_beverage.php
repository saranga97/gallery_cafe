<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] != "admin") {
    header("Location: login.php");
    exit();
}
include('config.php');

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];
    
    if ($action == 'add') {
        $item_code = $_POST['item_code'];
        $item_name = $_POST['item_name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $availability = $_POST['availability'];
        $cousin_type = $_POST['cousin_type'];

        $image = $_FILES['image']['name'];
        $target = "uploads/".basename($image);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $sql = "INSERT INTO menu_items (item_code, item_name, description, image, price, availability, cousin_type) 
                    VALUES ('$item_code', '$item_name', '$description', '$image', '$price', '$availability', '$cousin_type')";

            if ($conn->query($sql) === TRUE) {
                $message = "Food/Beverage added successfully!";
            } else {
                $message = "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            $message = "Failed to upload image.";
        }
    } elseif ($action == 'edit') {
        // Handle edit action
    } elseif ($action == 'delete') {
        $item_id = $_POST['item_id'];
        $sql = "DELETE FROM menu_items WHERE item_id='$item_id'";

        if ($conn->query($sql) === TRUE) {
            $message = "Item deleted successfully!";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$menu_items = $conn->query("SELECT * FROM menu_items");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Food and Beverage</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="js/scripts.js" defer></script>
    <style>
        .table-responsive {
            overflow-x: auto;
        }

        .table thead th,
        .table tbody td {
            font-size: 0.8rem;
        }

        .modal-backdrop {
            position: unset;
        }

        .form-group label {
            font-size: 0.8rem;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            font-size: 0.8rem;
        }

        .form-group .form-control {
            font-size: 0.8rem;
        }
    </style>
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
                    <a class="nav-link" href="admin_dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_pre_orders.php">Manage Pre Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_reservations.php">Manage Table Reservations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="manage_food_beverage.php">Manage Food/Beverage</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_users.php">Manage Users</a>
                </li>
            </ul>
            <div class="dropdown">
                <button class="dropbtn"><?php echo isset($_SESSION["username"]) ? $_SESSION["username"] : 'User'; ?>
                    <i class="fa fa-caret-down"></i>
                </button>
                <div style="margin-right: 90px;" class="dropdown-content">
                    <a href="account_settings.php">Account Settings</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div style="min-height: 85vh;" class="container mt-5">
        <h2 class="text-center">Manage Food and Beverage</h2>
        <div class="row mb-3">
            <div class="col text-right">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addFoodBeverageModal">Add Item</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Availability</th>
                        <th>Cousin Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $menu_items->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['item_code']; ?></td>
                            <td><?php echo $row['item_name']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td><?php echo $row['availability']; ?></td>
                            <td><?php echo $row['cousin_type']; ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm edit-btn" data-id="<?php echo $row['item_id']; ?>" data-item_code="<?php echo $row['item_code']; ?>" data-item_name="<?php echo $row['item_name']; ?>" data-description="<?php echo $row['description']; ?>" data-price="<?php echo $row['price']; ?>" data-availability="<?php echo $row['availability']; ?>" data-cousin_type="<?php echo $row['cousin_type']; ?>">Edit</button>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="<?php echo $row['item_id']; ?>">Delete</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 The Gallery Cafe</p>
    </div>

    <!-- Add Item Modal -->
    <div class="modal fade" id="addFoodBeverageModal" tabindex="-1" role="dialog" aria-labelledby="addFoodBeverageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFoodBeverageModalLabel">Add New Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data" id="foodBeverageForm">
                        <input type="hidden" name="action" value="add">
                        <div class="form-group">
                            <label for="item_code">Item Code:</label>
                            <input type="text" class="form-control" id="item_code" name="item_code" required>
                        </div>
                        <div class="form-group">
                            <label for="item_name">Item Name:</label>
                            <input type="text" class="form-control" id="item_name" name="item_name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Image:</label>
                            <input type="file" class="form-control" id="image" name="image" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Price:</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="availability">Availability:</label>
                            <input type="text" class="form-control" id="availability" name="availability" required>
                        </div>
                        <div class="form-group">
                            <label for="cousin_type">Cousin Type:</label>
                            <input type="text" class="form-control" id="cousin_type" name="cousin_type" required>
                        </div>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmAddModal">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Item Modal -->
    <div class="modal fade" id="editFoodBeverageModal" tabindex="-1" role="dialog" aria-labelledby="editFoodBeverageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editFoodBeverageModalLabel">Edit Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data" id="editFoodBeverageForm">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="item_id" id="edit_item_id">
                        <div class="form-group">
                            <label for="edit_item_code">Item Code:</label>
                            <input type="text" class="form-control" id="edit_item_code" name="item_code" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_item_name">Item Name:</label>
                            <input type="text" class="form-control" id="edit_item_name" name="item_name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_description">Description:</label>
                            <textarea class="form-control" id="edit_description" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_image">Image:</label>
                            <input type="file" class="form-control" id="edit_image" name="image">
                        </div>
                        <div class="form-group">
                            <label for="edit_price">Price:</label>
                            <input type="number" step="0.01" class="form-control" id="edit_price" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_availability">Availability:</label>
                            <input type="text" class="form-control" id="edit_availability" name="availability" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_cousin_type">Cousin Type:</label>
                            <input type="text" class="form-control" id="edit_cousin_type" name="cousin_type" required>
                        </div>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmEditModal">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Add Modal -->
    <div class="modal fade" id="confirmAddModal" tabindex="-1" role="dialog" aria-labelledby="confirmAddModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmAddModalLabel">Confirm Add Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to add this item?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" id="confirmAdd">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Edit Modal -->
    <div class="modal fade" id="confirmEditModal" tabindex="-1" role="dialog" aria-labelledby="confirmEditModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmEditModalLabel">Confirm Edit Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to edit this item?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" id="confirmEdit">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Delete Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this item?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo $message ?? ''; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#confirmAdd').click(function() {
                $('#foodBeverageForm').submit();
            });

            $('#confirmEdit').click(function() {
                $('#editFoodBeverageForm').submit();
            });

            $('#confirmDelete').click(function() {
                var item_id = $(this).data('id');
                $.post('manage_food_beverage.php', { action: 'delete', item_id: item_id }, function(response) {
                    location.reload();
                });
            });

            $('.edit-btn').click(function() {
                var item_id = $(this).data('id');
                var item_code = $(this).data('item_code');
                var item_name = $(this).data('item_name');
                var description = $(this).data('description');
                var price = $(this).data('price');
                var availability = $(this).data('availability');
                var cousin_type = $(this).data('cousin_type');

                $('#edit_item_id').val(item_id);
                $('#edit_item_code').val(item_code);
                $('#edit_item_name').val(item_name);
                $('#edit_description').val(description);
                $('#edit_price').val(price);
                $('#edit_availability').val(availability);
                $('#edit_cousin_type').val(cousin_type);

                $('#editFoodBeverageModal').modal('show');
            });

            $('.delete-btn').click(function() {
                var item_id = $(this).data('id');
                $('#confirmDelete').data('id', item_id);
                $('#confirmDeleteModal').modal('show');
            });

            <?php if (!empty($message)) : ?>
                $('#successModal').modal('show');
            <?php endif; ?>
        });
    </script>
</body>

</html>
