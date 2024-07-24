<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Gallery Cafe</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <style>
        .container {
            text-align: center;
            margin-top: 50px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            animation: fadeIn 0.5s;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            var loginModal = document.getElementById("loginForm");
            var registerModal = document.getElementById("registerForm");

            var loginBtn = document.getElementById("loginBtn");
            var registerBtn = document.getElementById("registerBtn");

            var closeLogin = document.getElementById("closeLogin");
            var closeRegister = document.getElementById("closeRegister");

            loginBtn.onclick = function () {
                loginModal.style.display = "block";
            }

            registerBtn.onclick = function () {
                registerModal.style.display = "block";
            }

            closeLogin.onclick = function () {
                loginModal.style.display = "none";
            }

            closeRegister.onclick = function () {
                registerModal.style.display = "none";
            }

            window.onclick = function (event) {
                if (event.target == loginModal) {
                    loginModal.style.display = "none";
                }
                if (event.target == registerModal) {
                    registerModal.style.display = "none";
                }
            }
        });
    </script>
</head>

<body>
    <div class="container">
        <h1>Welcome to The Gallery Cafe</h1>
        <button id="loginBtn" class="btn btn-warning">Login</button>
        <button id="registerBtn" class="btn btn-warning">Register</button>
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

