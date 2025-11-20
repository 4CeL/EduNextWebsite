<?php
session_start();
include 'db.php';

// PAGINATION
$limit = 3; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = ($page < 1) ? 1 : $page;
$offset = ($page - 1) * $limit;

// FETCH DATA
$sql_count = "SELECT COUNT(*) as total FROM ebooks";
$result_count = mysqli_query($conn, $sql_count);
$total_rows = mysqli_fetch_assoc($result_count)['total'];
$total_pages = ceil($total_rows / $limit);

$sql = "SELECT * FROM ebooks ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);

// HEADER LOGIC
$is_logged_in = isset($_SESSION['user_id']);
$profile_pic = 'default.jpg';
if ($is_logged_in) {
    $id_user = $_SESSION['user_id'];
    $q = "SELECT profile_pic FROM users WHERE id = '$id_user'";
    $res = mysqli_query($conn, $q);
    if ($row_user = mysqli_fetch_assoc($res)) {
        if (!empty($row_user['profile_pic'])) $profile_pic = $row_user['profile_pic'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Related E-Books - EduNext</title>
    <link rel="stylesheet" href="resources.css">
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
                <div class="profile-header" onclick="window.location.href='account.php'"><img src="img/<?php echo $profile_pic; ?>"></div>
            <?php else: ?>
                <a href="login.html"><button class="loginbutton">LOGIN.</button></a>
            <?php endif; ?>
            <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
        </div>
    </header>

    <div class="mobile-menu" id="mobileMenu">
        <a href="./home.php">Home</a>
        <a href="./aboutus.php">About Us</a>
        <a href="./forum.php">Forum</a>
        <?php if (!$is_logged_in): ?><a href="./login.html">Login</a><?php else: ?><a href="./account.php">My Account</a><a href="./logout.php">Logout</a><?php endif; ?>
    </div>

    <div class="hero-section">
        <a href="scholarships.php" class="back-link"><i class="fa-solid fa-chevron-left"></i></a>
        <h1>RELATED E - BOOKS</h1>
    </div>

    <div class="purple-bg-container"></div>

    <div class="resource-container">
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <div class="card">
            <img src="img/<?php echo $row['image']; ?>" class="card-img" alt="<?php echo $row['title']; ?>">
            
            <div class="meta-info">
                <div class="stars">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                </div>
                <div class="level-badge">
                    <span class="dot <?php echo ($row['level'] == 'Beginner') ? 'green' : 'orange'; ?>"></span>
                    <?php echo $row['level'] . " - " . $row['duration']; ?>
                </div>
            </div>

            <h3><?php echo $row['title']; ?></h3>
            <p><?php echo $row['description']; ?></p>
            
            <a href="<?php echo $row['download_url']; ?>" class="btn-action">Download</a>
        </div>
        <?php endwhile; ?>
    </div>

    <?php if ($total_pages > 1): ?>
    <div class="pagination">
        <a href="?page=<?php echo max(1, $page - 1); ?>"><i class="fa-solid fa-angles-left"></i></a>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
        <a href="?page=<?php echo min($total_pages, $page + 1); ?>"><i class="fa-solid fa-angles-right"></i></a>
    </div>
    <?php endif; ?>

    <script src="hamburger.js"></script>
</body>
</html>