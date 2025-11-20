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
        <title>Premium</title>
        <link rel="stylesheet" href="premium.css">

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

        <section class="judul">
            <h2>LEVEL UP YOUR FUTURE</h2>
            <h1>PREMIUM ACCESS. UNLIMITED OPPORTUNITY.</h1>
            <a href="#advantage"><button class="btn-premium">CHECK PREMIUM PACKET</button></a>
        </section>

        <section class="features" id="advantage">
            <h3>FEATURES</h3>
            <h2>PREMIUM ADVANTAGE</h2>

            <div class="features-table">
                <div class="table-header">
                    <div>FEATURE</div>
                    <div>FREE</div>
                    <div>PREMIUM</div>
                </div>
            
                <div class="table-row">
                    <div>Find Scholarships</div>
                    <div><span class="check">✓</span></div>
                    <div><span class="check">✓</span></div>
                </div>
            
                <div class="table-row">
                    <div>Course Recommendations</div>
                    <div><span class="check">✓</span></div>
                    <div><span class="check">✓</span></div>
                </div>
            
                <div class="table-row">
                    <div>E-books Access</div>
                    <div><span class="cross">✕</span></div>
                    <div><span class="check">✓</span></div>
                </div>
            
                <div class="table-row">
                    <div>Video Explanation</div>
                    <div><span class="cross">✕</span></div>
                    <div><span class="check">✓</span></div>
                </div>
            
                <div class="table-row">
                    <div>Community Forum</div>
                    <div><span class="cross">✕</span></div>
                    <div><span class="check">✓</span></div>
                </div>
            </div>
        </section>

        <section class="pricing">
            <h3>CHOOSE YOUR PLAN</h3>
            <h2>INVEST FOR YOUR FUTURE</h2>

            <div class="pricing-cards">
                <!-- Monthly Plan -->
                <div class="pricing-card">
                    <h3>MONTHLY</h3>
                    <div class="price">RP 59.000,-<span class="period">/Month</span></div>
                    <p>Full access to all premium features, suitable for short-term needs.</p>
                    <button onclick="choosePlan('monthly')" class="btn-secondary">CHOOSE THIS</button>
                </div>
            
                <!-- Annual Plan -->
                <div class="pricing-card featured">
                    <span class="badge">Most Popular !</span>
                    <h3>ANNUALY</h3>
                    <div class="price">RP 99.000,-<span class="period">/Year</span></div>
                    <p>The good and the best choice for true scholarship warriors</p>
                    <button onclick="choosePlan('annual')" class="btn-secondary">CHOOSE THIS</button>
                </div>
            </div>
        </section>

        <section class="testimonials">
        <h3>SUCCESS STORIES</h3>
        <h2>WHAT THEY SAID</h2>
        
        <div class="testimonial-cards">
            <div class="testimonial-card">
                <p>"EduNext membantu saya menemukan beasiswa yang sesuai dengan jurusan saya. Panduannya sangat jelas dan memudahkan proses aplikasi."</p>
                <div class="author">
                    <strong>- Aisha Rahman</strong><br>
                    <span>Awarded: ASEAN Undergraduate Scholarship</span>
                </div>
            </div>
            
            <div class="testimonial-card">
                <p>"Sebelum mengenal EDUNEXT, saya tidak tahu harus mulai dari mana. Sekarang saya sudah berhasil lolos beasiswa luar negeri berkat rekomendasi kursus dan tips dari sini."</p>
                <div class="author">
                    <strong>- Daniel Wijaya</strong><br>
                    <span>Awarded: LPDP Master's Scholarship</span>
                </div>
            </div>
        </div>
    </section>
        <script src="hamburger.js"></script>
        <script src="premium.js"></script>
    </body>
</html>
