<?php
session_start();
include 'db.php'; // Pastikan koneksi database terhubung

// CEK STATUS LOGIN
$is_logged_in = isset($_SESSION['user_id']);
$tampil_foto = 'default.jpg'; // Default foto jika belum login/tidak punya foto

if ($is_logged_in) {
    $id_user = $_SESSION['user_id'];
    
    // Ambil foto profil dari database
    $query = "SELECT profile_pic FROM users WHERE id = '$id_user'";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        if (!empty($data['profile_pic'])) {
            $tampil_foto = $data['profile_pic'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>About Us - EduNext</title>
    
    <link rel="stylesheet" href="aboutusstyle.css">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lalezar&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@100..900&family=Lalezar&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Notable&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oooh+Baby&display=swap" rel="stylesheet">

</head>

<body>

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
                    <img src="img/<?php echo $tampil_foto; ?>" alt="Profile">
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

    <section class="bagianatas">
        <p>FOUNDED IN 2025</p>
        <h1>AN OPPORTUNITY FOCUSED<br>SCHOLARSHIP ADVISOR.</h1>
        <p class="spaced">LEVEL UP YOUR FUTURE</p>
        <p class="lastline">With us</p>
    </section>

    <section class="bagianbawah">
        <div class="kiri">
            </div>
        <div class="kanan">
            <h2>WHAT WE DO</h2>
            <img src="./img/aboutimg/line1.png" alt="">
            
            <p style="margin-top: 1.5rem;">At EduNext, we simplify the journey to your academic and<br>career goals.</p>
            
            <p style="margin-top: 2.3rem;">Our platform helps students discover scholarships, explore<br>recommended courses, and access e-books designed to<br>guide every stage of their preparation.</p>
            
            <p style="margin-top: 2.3rem;">Whether you're applying locally or internationally, we make<br>sure you have the knowledge and confidence to stand out.</p>
            
            <img src="./img/aboutimg/line1.png" alt="" style="margin-top: 1.5rem;">
            <p style="margin-top: 1.7rem; font-size: 1.5rem;"><b>100+</b> available courses</p>
            
            <img src="./img/aboutimg/line1.png" alt="" style="margin-top: 1.5rem;">
            <p style="margin-top: 1.7rem; font-size: 1.5rem;"><b>50+</b> e-books</p>
        </div>
    </section>

    <footer>
        <div class="footerleft">
            <div class="footerlinks">
                <p>Instagram</p>
                <p>LinkedIn</p>
            </div>
            <div class="footergianttext">
                <h1>GOT QUESTIONS?<br>GET IN TOUCH.</h1>
            </div>
            <p class="footerleftsmalltext">We're always ready to help you find your way to your dream scholarship.
                <br>Connect with us on Instagram or LinkedIn, or send us your questions through our contact form.
                <br> With EduNext, every step brings you closer to the future you dream of.
            </p>
        </div>

        <div class="footerright">
            <img src="./img/footer/footerlogo.png" alt="">
        </div>

    </footer>
    
    <script src="hamburger.js"></script>
</body>

</html>