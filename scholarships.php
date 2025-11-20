<?php
session_start();
include 'db.php';

// --- 1. LOGIKA HEADER & LOGIN ---
$is_logged_in = isset($_SESSION['user_id']);
$profile_pic = 'default.jpg';

if ($is_logged_in) {
    $id_user = $_SESSION['user_id'];
    $query = "SELECT profile_pic FROM users WHERE id = '$id_user'";
    $result = mysqli_query($conn, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        if (!empty($row['profile_pic'])) {
            $profile_pic = $row['profile_pic'];
        }
    }
}

// --- 2. LOGIKA SEARCH & PAGINATION ---
$limit = 6; // Maksimal 6 beasiswa per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = ($page < 1) ? 1 : $page;
$offset = ($page - 1) * $limit;

// Ambil keyword pencarian
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Query Dasar (Hitung Total Data untuk Pagination)
$where_clause = "";
if ($search != '') {
    $where_clause = "WHERE name LIKE '%$search%' OR university LIKE '%$search%'";
}

$sql_count = "SELECT COUNT(*) as total FROM scholarships $where_clause";
$result_count = mysqli_query($conn, $sql_count);
$row_count = mysqli_fetch_assoc($result_count);
$total_scholarships = $row_count['total'];
$total_pages = ceil($total_scholarships / $limit);

// Query Ambil Data (Dengan Limit)
$sql_data = "SELECT * FROM scholarships $where_clause ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result_scholarships = mysqli_query($conn, $sql_data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarships - EduNext</title>
    <link rel="stylesheet" href="scholarships.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@400;700&family=Lalezar&family=Notable&family=Oooh+Baby&display=swap" rel="stylesheet">
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

    <div class="hero-section">
        <h1>SCHOLARSHIPS</h1>
        <div class="purple-wave"></div> </div>

    <div class="search-container">
        <form action="" method="GET" class="search-box">
            <input type="text" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button> </form>
    </div>

    <section class="scholarship-grid">
        
        <?php if (mysqli_num_rows($result_scholarships) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result_scholarships)): 
                // Memecah string benefits dan field_of_study menjadi array
                $benefits = explode(',', $row['benefits']);
                $fields = explode(',', $row['field_of_study']);
            ?>
            <div class="scholarship-card">
                <div class="card-header-logo">
                    <img src="img/binus_logo.png" alt="University Logo" class="uni-logo"> 
                </div>

                <div class="card-title-row">
                    <h3><?php echo $row['name']; ?></h3>
                    <a href="scholarship_detail.php?id=<?php echo $row['id']; ?>" class="btn-details">⋮ Details</a>
                </div>

                <div class="card-body">
                    <div class="info-group">
                        <h4>Benefits:</h4>
                        <ul>
                            <?php foreach($benefits as $b): ?>
                                <li>• <?php echo trim($b); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="info-group">
                        <h4>Field of Study:</h4>
                        <ul>
                            <?php foreach($fields as $f): ?>
                                <li>• <?php echo trim($f); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="dots">
                        <span class="dot red"></span>
                        <span class="dot yellow"></span>
                        <span class="dot green"></span>
                    </div>
                    <i class="fa-solid fa-bookmark bookmark-icon"></i>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align: center; grid-column: 1/-1; font-size: 1.2rem;">No scholarships found.</p>
        <?php endif; ?>

    </section>

    <?php if ($total_pages > 1): ?>
    <div class="pagination">
        <a href="?page=1&search=<?php echo $search; ?>">&laquo;</a>
        <a href="?page=<?php echo max(1, $page - 1); ?>&search=<?php echo $search; ?>">&lt;</a>
        
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>

        <a href="?page=<?php echo min($total_pages, $page + 1); ?>&search=<?php echo $search; ?>">&gt;</a>
        <a href="?page=<?php echo $total_pages; ?>&search=<?php echo $search; ?>">&raquo;</a>
    </div>
    <?php endif; ?>

    <div class="footer-text">
        Choose your path
    </div>

    <script src="hamburger.js"></script>
</body>
</html>