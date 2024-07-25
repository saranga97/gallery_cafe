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

        #loginBtn {
            background-color: #ff9800;
            border: none;
            color: #fff;
            border-radius: 30px;
            transition: all 0.3s;
        }

        #loginBtn:hover {
            background-color: #e67e00;
            color: #fff;
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
            background-color: rgba(0, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
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

        section#home {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
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

            loginBtn.onclick = function() {
                loginModal.style.display = "flex";
            }

            registerBtn.onclick = function() {
                registerModal.style.display = "flex";
            }

            closeLogin.onclick = function() {
                loginModal.style.display = "none";
            }

            closeRegister.onclick = function() {
                registerModal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == loginModal) {
                    loginModal.style.display = "none";
                }
                if (event.target == registerModal) {
                    registerModal.style.display = "none";
                }
            }
        });

        function login(event) {
            event.preventDefault();
            var form = document.getElementById("loginFormElement");
            var formData = new FormData(form);

            fetch('login.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        if (data.user_type === 'admin') {
                            window.location.href = 'admin_dashboard.php';
                        } else if (data.user_type === 'staff') {
                            window.location.href = 'staff_dashboard.php';
                        } else {
                            window.location.href = 'customer_dashboard.php';
                        }
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</head>

<body>
    <div style="max-height: 100vh;">
        <section id="home" class="parallax-section" style="background: url('uploads/cover.jpg') no-repeat center center/cover; height: 100vh; color: #fff;">
            <div class="gradient-overlay" style="background: rgba(0, 0, 0, 0.6); height: 100%; display: flex; align-items: center;">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8 text-center">
                            <h1 class="wow fadeInUp" data-wow-delay="0.6s" style="font-size: 3rem; font-weight: 700; letter-spacing: 2px;">The Gallery Cafe</h1>
                            <p class="wow fadeInUp" data-wow-delay="1.0s" style="font-size: 1.2rem; margin-top: 20px;">Welcome to The Gallery Cafe, where we offer an exquisite dining experience with a blend of contemporary and traditional flavors. Enjoy a meal with us and make memories that last a lifetime.</p>
                            <a id="loginBtn" class="wow fadeInUp btn btn-default smoothScroll" data-wow-delay="1.3s" style="margin-top: 30px; padding: 10px 30px; font-size: 1.2rem; background-color: #ff9800; border: none; color: #fff; border-radius: 30px; transition: all 0.3s;">Discover Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <div style="visibility: hidden; display:none">
            <button id="loginBtn" style="visibility: hidden;" class="btn btn-warning">Login</button>
            <button id="registerBtn" style="visibility: hidden;" class="btn btn-warning">Register</button>
        </div>

        <div id="loginForm" class="modal">
            <div class="modal-content">
                <span class="close" id="closeLogin">&times;</span>
                <h2>Login</h2>
                <form id="loginFormElement" method="post" onsubmit="login(event)">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                    <p class="text-center mt-3">Don't have an account? <a href="#" id="registerLink">Sign Up</a></p>
                </form>
            </div>
        </div>

        <div id="registerForm" class="modal">
            <div class="modal-content">
                <span class="close" id="closeRegister">&times;</span>
                <h2>Register</h2>
                <form method="post" action="register.php">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address:</label>
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
                    <button type="submit" class="btn btn-primary">Register</button>
                    <p class="text-center mt-3">Already have an account? <a href="#" id="loginLink">Login</a></p>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('registerLink').onclick = function() {
            document.getElementById('closeLogin').click();
            document.getElementById('registerBtn').click();
        };
        document.getElementById('loginLink').onclick = function() {
            document.getElementById('closeRegister').click();
            document.getElementById('loginBtn').click();
        };
    </script>
</body>

</html>