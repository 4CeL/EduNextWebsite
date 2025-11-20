<?php
session_start();
include 'db.php'; // Pastikan file db.php ada di folder yang sama

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

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
            $profile_pic = $row['profile_pic']; // Variabelnya bernama $profile_pic
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Homepage - EduNext</title>
        
        <link rel="stylesheet" href="home.css">
        
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

        <section class="konten1">
            <div class="teksgede">
                <img src="./img/homeimg/linebackground.png" alt="" class="linebackground">
                <h1>
                    FIND<img src="./img/homeimg/photo1.png" class="photo1">&nbsp;&nbsp;&nbsp;&nbsp;PREPARE<br>
                    <span class="indent-line">ACHIEVE<img src="./img/homeimg/photo2.png" class="photo2"><br><span class="indent-line2">WIN.</span></span>
                </h1>
            </div>
            <div class="konten1bawah">
                <div class="konten1bawahkiri">
                    <img src="./img/homeimg/Line 1.png" alt="" class="line1">
                    <p>Discover the best scholarship opportunities,<br> prepare yourself, and achieve your academic<br> dreams with EduNext. We help students navigate<br> the world of scholarships and self-development<br> courses—in an easier and more targeted way.</p>
                    <h1>WHAT WE DO</h1>
                    <div class="arrowbawah">
                        <img src="./img/homeimg/arrow-down.png" alt="">
                    </div>
                </div>
                <div class="konten1bawahkanan">
                    <a href="./scholarships.php"><button class="checkitoutbutton">CHECK IT OUT&nbsp;&nbsp;></button></a>
                </div>
            </div>
        </section>

        <section class="konten2">
            <div class="kotakkonten2">
                <div class="konten2bagianatas">
                    <h2>REIMAGINING SCHOLARS,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ONE STEP AT A TIME</h2>
                </div>
                <div class="konten2bagiantengah">
                    <p>E-BOOKS.</p>
                    <p>SCHOLARSHIPS</p>
                </div>
            </div>
        </section>

        <section class="konten3">
            <div class="konten3bagianatas">
                <p>WE MAKE IT POSSIBLE</p>
            </div>
            <div class="konten3bagianbawah">
                <p>for you</p>
            </div>
        </section>

        <section class="konten4">
            <div class="konten4kiri">
                <div class="konten4kirigaris"></div>
                <div class="konten4kiriisi">
                    <div class="isi1">
                        <a href="register.html"><p class="isi1atas">SIGN UP NOW ></p></a>
                        <p class="isi1bawah">And experience a new <br>side to scholarships</p>
                    </div>
                    <div class="isi2">
                        <p>Experience a new way to explore scholarship opportunities.Join thousands of students who have found their way to their dream universities.</p>
                    </div>
                    <div class="isi3">
                        <p>With EduNext, your journey to academic success starts with the right guidance and the right opportunities.</p>
                    </div>
                    <div class="isi4">
                        <p>We'll help you from the search stage to preparation and application to make sure that you can stand out among other applicants and submit with confidence.</p>
                    </div>
                </div>
            </div>
            <div class="konten4kanan">
                <div class="konten4kananisi"></div>
                <div class="konten4kanangaris"></div>
            </div>
        </section>

        <section class="konten5">
            <div class="konten5header">
                <p>TESTIMONIALS</p>
                <h1>WHAT THEY SAID</h1>
            </div>
            <div class="konten5card">
                <div class="testimonials-cards">
                    <div class="testimonial-card">
                        <p class="quote">
                            “EduNext membantu saya menemukan beasiswa yang sesuai dengan jurusan saya.
                            Panduannya sangat jelas dan memudahkan proses aplikasi.”
                        </p>
                        <p class="name">– Aisha Rahman</p>
                        <p class="award">Awardee, ASEAN Undergraduate Scholarship</p>
                    </div>
                    <div class="testimonial-card">
                        <p class="quote">
                            “Sebelum mengenal EDUNEXT, saya tidak tahu harus mulai dari mana.
                            Sekarang, saya sudah berhasil lolos beasiswa luar negeri berkat 
                            rekomendasi kursus dan tips dari sini.”
                        </p>
                        <p class="name">– Daniel Wijaya</p>
                        <p class="award">Awardee, LPDP Master's Scholarship</p>
                    </div>
                </div>
            </div>
        </section>

        <footer>
            <div class="footerleft">
                <div class="footerlinks">
                    <a href="https://www.instagram.com/edunextwebsite?igsh=eWI4eGw0OWxxbWZi"><p>Instagram</p></a>
                    <p>LinkedIn</p>
                </div>
                <div class="footergianttext">
                    <h1>GOT QUESTIONS?<br>GET IN TOUCH.</h1>
                </div>
                <p class="footerleftsmalltext">We're always ready to help you find your way to your dream scholarship.
                    <br>Connect with us on Instagram or LinkedIn, or send us your questions through our contact form.
                    <br> With EduNext, every step brings you closer to the future you dream of.</p>
            </div>

            <div class="footerright">
                <img src="./img/footer/footerlogo.png" alt="Footer Logo">
            </div>

        </footer>
        <script src="hamburger.js"></script>
    </body>
</html>