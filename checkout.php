<?php
session_start();
include 'db.php'; // Pastikan koneksi database terhubung

// Cek Status Login
$is_logged_in = isset($_SESSION['user_id']);
$profile_pic = 'default.jpg'; // Default foto

if ($is_logged_in) {
    $id_user = $_SESSION['user_id'];
    // Ambil data foto terbaru dari database
    $query = "SELECT profile_pic FROM users WHERE id = '$id_user'";
    $result = mysqli_query($conn, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        if (!empty($row['profile_pic'])) {
            $profile_pic = $row['profile_pic'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Homepage</title>
        <link rel="stylesheet" href="checkout.css">

        <!-- Ini buat Lalezar (tombol login) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lalezar&display=swap" rel="stylesheet">

        <!-- Font Notable -->
        <link href="https://fonts.googleapis.com/css2?family=Notable&display=swap" rel="stylesheet">
        
        <!-- Ini buat Kumbh Sans (header bagian tengah) -->
        <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@100..900&family=Lalezar&display=swap" rel="stylesheet">

        <!-- Ini buat notable font (tulisan gede) -->
        <link href="https://fonts.googleapis.com/css2?family=Notable&display=swap" rel="stylesheet">

        <!-- Ini buat bebas neue (tulisan di gambar konten2) -->
        <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">

        <!-- Ini buat Oooh Baby (tulisan for you di konten3) -->
         <link href="https://fonts.googleapis.com/css2?family=Oooh+Baby&display=swap" rel="stylesheet">

    </head>
    <body>

        <!-- Header -->
        <header class="headerbar">
            <img src="img/header/Group 17.png" class="headerlogo" alt="Logo">
            
            <div class="headerbarmiddle">
                <a href="./home.php">Home</a>
                <a href="./aboutus.php">About Us</a>
                <a href="./forum.php">Forum</a>
            </div>

            <div style="display: flex; align-items: center; gap: 15px;">
                <?php if ($is_logged_in): ?>
                    <div class="profile-header" onclick="window.location.href='account.php'" title="My Account">
                        <img src="img/<?php echo $profile_pic; ?>" alt="Profile">
                    </div>
                <?php else: ?>
                    <a href="login.html"><button class="loginbutton">LOGIN.</button></a>
                <?php endif; ?>

                <div class="hamburger" id="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </header>

        <div class="mobile-menu" id="mobileMenu">
            <a href="./home.php">Home</a>
            <a href="./aboutus.php">About Us</a>
            <a href="./forum.php">Forum</a>
            
            <?php if (!$is_logged_in): ?>
                <a href="./login.html">Login</a>
            <?php else: ?>
                <a href="./account.php">My Account</a>
                <a href="./logout.php">Logout</a> 
            <?php endif; ?>
        </div>

        <section class="container">
        <!-- LEFT SECTION -->
        <div class="payment-box">
            <h2 class="title">COMPLETE YOUR PAYMENT</h2>

            <label>Full Name</label>
            <input type="text" placeholder="Enter your full name">

            <label>Email Address</label>
            <input type="email" placeholder="example@email.com">

            <label>Choose Payment Method</label>

            <div class="payment-methods">
                <div class="method"><input type="radio" name="pay"> <span>QRIS</span></div>
                <div class="method"><input type="radio" name="pay"> <span>Gopay</span></div>
                <div class="method"><input type="radio" name="pay"> <span>Virtual Account</span></div>
                <div class="method"><input type="radio" name="pay"> <span>Credit Card</span></div>
            </div>

            <button class="pay-btn">PAY NOW</button>
        </div>

        <!-- RIGHT SECTION -->
        <div class="summary-box">
            <h2 class="title">ORDER SUMMARY</h2>

            <div class="summary-line"></div>
            <div class="item">
                <p id="plan-title"></p>
                <span id="plan-price"></span>
            </div>

            <div class="summary-line"></div>
            <div class="item total">
                <p>Total Payment</p>
                <span id="total-payment"></span>
            </div>

            <p class="secure"><span>🔒</span> Secure & Encrypted Payment</p>
        </div>

    </section>

    
    <script>
        function toggleMenu() {
            document.getElementById("mobileMenu").classList.toggle("active");
        }
    </script>
    <script src="hamburger.js"></script>
    <script src="checkout.js"></script>
    </body>
</html>