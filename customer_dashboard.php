<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] != "customer") {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="js/scripts.js" defer></script>

    <!-- Site Icons -->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png" />

    <!-- color -->
    <link id="changeable-colors" rel="stylesheet" href="css/colors/orange.css" />

    <!-- Modernizer -->
    <script src="js/modernizer.js"></script>

</head>

<body>
    <div id="loader">
        <div id="status"></div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: transparent;">
        <a class="navbar-brand" href="#">The Gallery Cafe</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="customer_dashboard.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view_menu_items.php">Menu Items</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="make_reservation.php">Table Reservations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pre_order.php">Pre-order</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pre_order.php">Parking</a>
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
    <div id="banner" class="banner full-screen-mode parallax">
        <div class="container pr">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="banner-static">
                    <div class="banner-text">
                        <div class="banner-cell">
                            <h1>
                                Dinner with us
                                <span class="typer" id="some-id" data-delay="200" data-delim=":" data-words="Friends:Family:Officemates" data-colors="red"></span><span class="cursor" data-cursorDisplay="_" data-owner="some-id"></span>
                            </h1>
                            <h2>Accidental appearances</h2>
                            <p>
                                Join us for a delightful dining experience where every meal is crafted with care and passion. Whether you are with friends, family, or officemates, The Gallery Cafe is the perfect place to enjoy great food and great company.
                            </p>
                            <div class="book-btn">
                                <a href="make_reservation.php" class="table-btn hvr-underline-from-center">Book my Table</a>
                            </div>
                            <a href="#about">
                                <div class="mouse"></div>
                            </a>
                        </div>

                        <!-- end banner-cell -->
                    </div>
                    <!-- end banner-text -->
                </div>
                <!-- end banner-static -->
            </div>
            <!-- end col -->
        </div>
        <!-- end container -->
    </div>

    <div id="about" class="about-main pad-top-100 pad-bottom-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">
                        <h2 class="block-title">About Us</h2>
                        <h3>IT STARTED, QUITE SIMPLY, LIKE THIS...</h3>
                        <p>
                            The Gallery Cafe began as a simple idea: to provide a unique dining experience that combines exquisite cuisine with a warm, inviting atmosphere. Our founders envisioned a place where people could gather to enjoy delicious meals, engage in meaningful conversations, and create lasting memories.
                        </p>

                        <p>
                            Our journey started with a passion for culinary excellence and a commitment to using the freshest, highest quality ingredients. From our humble beginnings, we have grown into a beloved destination for food lovers, known for our diverse menu that features a blend of local and international flavors.
                        </p>

                        <p>
                            At The Gallery Cafe, we believe that dining is more than just eating – it is an experience. Our team is dedicated to providing exceptional service, creating an ambiance that feels like a home away from home. Whether you are joining us for a casual meal, a special celebration, or a quick bite, we strive to make every visit memorable.
                        </p>

                        <p>
                            We are proud to be a part of this community and grateful for the support of our loyal customers. As we continue to grow and evolve, our mission remains the same: to deliver extraordinary food and unparalleled hospitality. Welcome to The Gallery Cafe – where every meal is a masterpiece.
                        </p>
                    </div>

                </div>
                <!-- end col -->
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="wow fadeIn" data-wow-duration="1s" data-wow-delay="0.1s">
                        <div class="about-images">
                            <img class="about-main" src="images/about-main.jpg" alt="About Main Image" />
                            <img class="about-inset" src="images/about-inset.jpg" alt="About Inset Image" />
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>

    <div class="container content mt-5" style="background-color: #333; color: white; padding: 20px; border-radius: 10px;">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="mb-4" style="color: #FFD700;">Want to Pre-Reserve?</h2>
                <div class="card mb-4" style="background-color: #444; color: white;">
                    <div class="card-body">
                        <h3 class="card-title" style="color: #FFD700;">Make a Reservation</h3>
                        <p class="card-text">Reserve your table in advance and enjoy our exclusive dining experience.</p>
                        <a href="make_reservation.php" class="btn btn-warning btn-lg">Make Reservation</a>
                    </div>
                </div>
                <div class="card" style="background-color: #444; color: white;">
                    <div class="card-body">
                        <h3 class="card-title" style="color: #FFD700;">Pre-order Food</h3>
                        <p class="card-text">Pre-order your favorite dishes and have them ready when you arrive.</p>
                        <a href="pre_order.php" class="btn btn-warning btn-lg">Pre-order</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="margin-top: 50px;" class="footer">
        <p>&copy; 2024 The Gallery Cafe</p>
    </div>

    <!-- ALL JS FILES -->
    <script src="js/all.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- ALL PLUGINS -->
    <script src="js/custom.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>