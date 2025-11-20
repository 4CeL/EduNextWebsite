<?php
session_start();
include 'db.php';

// 1. Ambil ID dari URL
if (!isset($_GET['id'])) {
    header("Location: scholarships.php");
    exit();
}

$id_scholarship = mysqli_real_escape_string($conn, $_GET['id']);

// 2. Ambil Data Beasiswa berdasarkan ID
$sql = "SELECT * FROM scholarships WHERE id = '$id_scholarship'";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "Scholarship not found.";
    exit();
}

// Pecah data text menjadi array (karena di database dipisah koma)
$criteria_list = explode(',', $data['criteria'] ?? ''); 
$dates_list = explode(',', $data['important_dates'] ?? '');

// 3. Logic Header (Sama seperti page lain)
$is_logged_in = isset($_SESSION['user_id']);
$profile_pic = 'default.jpg';
if ($is_logged_in) {
    $id_user = $_SESSION['user_id'];
    $query_user = "SELECT profile_pic FROM users WHERE id = '$id_user'";
    $res_user = mysqli_query($conn, $query_user);
    if ($row_user = mysqli_fetch_assoc($res_user)) {
        if (!empty($row_user['profile_pic'])) $profile_pic = $row_user['profile_pic'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['name']; ?> - Detail</title>
    <link rel="stylesheet" href="scholarship_detail.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@400;700&family=Lalezar&family=Notable&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                <div class="profile-header" onclick="window.location.href='account.php'">
                    <img src="img/<?php echo $profile_pic; ?>" alt="Profile">
                </div>
            <?php else: ?>
                <a href="login.html"><button class="loginbutton">LOGIN.</button></a>
            <?php endif; ?>
            <div class="hamburger" id="hamburger">
                <span></span><span></span><span></span>
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

    <div class="detail-container">
        
        <div class="left-content">
            <h1 class="scholarship-title"><?php echo strtoupper($data['name']); ?></h1>
            
            <div class="image-card">
                <img src="img/binus_logo.png" alt="University Logo" class="main-img"> <div class="uni-info">
                    <p>By<br><strong><?php echo $data['university']; ?></strong></p>
                </div>
            </div>
            
            <p class="year-text">2018 – Present</p>
        </div>

        <div class="vertical-line"></div>

        <div class="right-content">
            
            <div class="info-section">
                <h3>Criteria and Eligibility</h3>
                <ul>
                    <?php foreach($criteria_list as $item): ?>
                        <?php if(trim($item) != ''): ?>
                            <li><?php echo trim($item); ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="info-section">
                <h3>Registration and Deadline</h3>
                <p><?php echo $data['registration_desc']; ?></p>
                <ul class="no-bullet">
                    <?php foreach($dates_list as $date): ?>
                        <?php if(trim($date) != ''): ?>
                            <li>• <?php echo trim($date); ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="related-buttons">
                <a href="courses.php" class="related-btn">
                    RELATED<br>COURSES
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
                <a href="ebook.php" class="related-btn">
                    RELATED<br>E-BOOKS
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </div>

        </div>

    </div>

    <script src="hamburger.js"></script>
</body>
</html>