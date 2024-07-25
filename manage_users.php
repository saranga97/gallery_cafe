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
        $name = $_POST['name'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $address = $_POST['address'];
        $user_type = $_POST['user_type'];

        if ($password !== $confirm_password) {
            $message = "Passwords do not match!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (name, email, username, password, address, user_type) 
                    VALUES ('$name', '$email', '$username', '$hashed_password', '$address', '$user_type')";

            if ($conn->query($sql) === TRUE) {
                $message = "User added successfully!";
            } else {
                $message = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } elseif ($action == 'edit') {
        $user_id = $_POST['user_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $address = $_POST['address'];
        $user_type = $_POST['user_type'];

        $sql = "UPDATE users SET name='$name', email='$email', username='$username', address='$address', user_type='$user_type' 
                WHERE user_id='$user_id'";

        if ($conn->query($sql) === TRUE) {
            $message = "User updated successfully!";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif ($action == 'delete') {
        $user_id = $_POST['user_id'];
        $sql = "DELETE FROM users WHERE user_id='$user_id'";

        if ($conn->query($sql) === TRUE) {
            $message = "User deleted successfully!";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$users = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
                    <a class="nav-link" href="manage_food_beverage.php">Manage Food/Beverage</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="manage_users.php">Manage Users</a>
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
        <h2 class="text-center">Manage Users</h2>
        <div class="row mb-3">
            <div class="col text-right">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">Add User</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>User Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $users->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['user_type']; ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm edit-btn" data-id="<?php echo $row['user_id']; ?>" data-name="<?php echo $row['name']; ?>" data-email="<?php echo $row['email']; ?>" data-username="<?php echo $row['username']; ?>" data-address="<?php echo $row['address']; ?>" data-user_type="<?php echo $row['user_type']; ?>">Edit</button>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="<?php echo $row['user_id']; ?>">Delete</button>
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

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="userForm">
                        <input type="hidden" name="action" value="add">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password:</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address:</label>
                            <textarea class="form-control" id="address" name="address" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="user_type">User Type:</label>
                            <select class="form-control" id="user_type" name="user_type" required>
                                <option value="customer">Customer</option>
                                <option value="admin">Admin</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmAddModal">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="editUserForm">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="user_id" id="edit_user_id">
                        <div class="form-group">
                            <label for="edit_name">Name:</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_email">Email:</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_username">Username:</label>
                            <input type="text" class="form-control" id="edit_username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_address">Address:</label>
                            <textarea class="form-control" id="edit_address" name="address" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_user_type">User Type:</label>
                            <select class="form-control" id="edit_user_type" name="user_type" required>
                                <option value="customer">Customer</option>
                                <option value="admin">Admin</option>
                                <option value="staff">Staff</option>
                            </select>
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
                    <h5 class="modal-title" id="confirmAddModalLabel">Confirm Add User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to add this user?
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
                    <h5 class="modal-title" id="confirmEditModalLabel">Confirm Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to edit this user?
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
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user?
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

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#confirmAdd').click(function() {
                $('#userForm').submit();
            });

            $('#confirmEdit').click(function() {
                $('#editUserForm').submit();
            });

            $('#confirmDelete').click(function() {
                var user_id = $(this).data('id');
                $.post('manage_users.php', { action: 'delete', user_id: user_id }, function(response) {
                    location.reload();
                });
            });

            $('.edit-btn').click(function() {
                var user_id = $(this).data('id');
                var name = $(this).data('name');
                var email = $(this).data('email');
                var username = $(this).data('username');
                var address = $(this).data('address');
                var user_type = $(this).data('user_type');

                $('#edit_user_id').val(user_id);
                $('#edit_name').val(name);
                $('#edit_email').val(email);
                $('#edit_username').val(username);
                $('#edit_address').val(address);
                $('#edit_user_type').val(user_type);

                $('#editUserModal').modal('show');
            });

            $('.delete-btn').click(function() {
                var user_id = $(this).data('id');
                $('#confirmDelete').data('id', user_id);
                $('#confirmDeleteModal').modal('show');
            });

            <?php if (!empty($message)) : ?>
                $('#successModal').modal('show');
            <?php endif; ?>
        });
    </script>
</body>

</html>
