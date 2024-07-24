<!DOCTYPE html>
<html>
<head>
    <title>The Gallery Café</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <script src="js/scripts.js" defer></script>
</head>
<body>
    <div class="container">
        <h1>Welcome to The Gallery Café</h1>
        <button id="loginBtn">Login</button>
        <button id="registerBtn">Register</button>
    </div>

    <div id="loginForm" class="modal">
        <div class="modal-content">
            <span class="close" id="closeLogin">&times;</span>
            <?php include('login.php'); ?>
        </div>
    </div>

    <div id="registerForm" class="modal">
        <div class="modal-content">
            <span class="close" id="closeRegister">&times;</span>
            <?php include('register.php'); ?>
        </div>
    </div>
</body>
</html>
