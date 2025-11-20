<?php
session_start();
include 'db.php';

// --- 1. KONFIGURASI PAGINATION ---
$limit = 4; // Jumlah thread per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = ($page < 1) ? 1 : $page; 
$offset = ($page - 1) * $limit;

// --- 2. CEK LOGIN & DATA USER ---
$is_logged_in = isset($_SESSION['user_id']);
$profile_pic = 'default.jpg';
$current_user_id = 0;

if ($is_logged_in) {
    $id_user = $_SESSION['user_id'];
    $current_user_id = $id_user;
    $query = "SELECT * FROM users WHERE id = '$id_user'";
    $result = mysqli_query($conn, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        if (!empty($row['profile_pic'])) {
            $profile_pic = $row['profile_pic'];
        }
    }
}

// --- 3. HITUNG TOTAL HALAMAN ---
$sql_count = "SELECT COUNT(*) as total FROM threads";
$result_count = mysqli_query($conn, $sql_count);
$row_count = mysqli_fetch_assoc($result_count);
$total_threads = $row_count['total'];
$total_pages = ceil($total_threads / $limit);

// --- 4. AMBIL DATA THREAD ---
$sql_threads = "SELECT threads.*, users.first_name, users.last_name, users.profile_pic AS user_pic 
                FROM threads 
                JOIN users ON threads.user_id = users.id 
                ORDER BY threads.created_at DESC 
                LIMIT $limit OFFSET $offset";
$result_threads = mysqli_query($conn, $sql_threads);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum - EduNext</title>
    
    <link rel="stylesheet" href="forum.css">
    
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

    <div class="forum-container">
        
        <div class="sidebar">
            <div class="sidebar-menu active">
                <i class="fa-regular fa-star"></i>
                <div><h3>Newest and recent</h3><p>Find the latest</p></div>
            </div>
            <div class="sidebar-menu">
                <i class="fa-regular fa-comment-dots"></i>
                <div><h3>Recommended</h3><p>Just for you</p></div>
            </div>
            <div class="sidebar-menu">
                <i class="fa-solid fa-arrow-trend-up"></i>
                <div><h3>Following</h3><p>People you know</p></div>
            </div>
            <div class="vertical-text-container">
                <h1 class="vertical-text">FORUM</h1>
            </div>
        </div>

        <div class="main-feed">

            <div class="feed-header">
                
                <div class="post-box-wrapper">
                    <?php if ($is_logged_in): ?>
                    <div class="create-post-card">
                        <img src="img/<?php echo $profile_pic; ?>" class="user-avatar-small">
                        <form action="create_post.php" method="POST" enctype="multipart/form-data" class="post-form">
                            <input type="text" name="content" placeholder="Share what's on your mind..." required autocomplete="off">
                            
                            <input type="file" name="thread_image" id="file-input" style="display: none;">
                            <label for="file-input" class="icon-btn"><i class="fa-regular fa-image"></i></label>
                            
                            <button type="submit" name="submit_thread" class="btn-create">Create Post</button>
                        </form>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="date-display">
                    <h2><?php echo date('d / m / Y'); ?></h2>
                    <h1><?php echo strtoupper(date('l')); ?></h1>
                </div>

            </div>

            <?php while($row = mysqli_fetch_assoc($result_threads)): 
                $thread_id = $row['id'];
                
                // Logic Like
                $check_like = mysqli_query($conn, "SELECT * FROM thread_likes WHERE user_id = '$current_user_id' AND thread_id = '$thread_id'");
                $is_liked = (mysqli_num_rows($check_like) > 0);
                
                // Logic Comments Count
                $count_comments = mysqli_query($conn, "SELECT COUNT(*) as total FROM thread_comments WHERE thread_id = '$thread_id'");
                $total_comments = mysqli_fetch_assoc($count_comments)['total'];
                
                // Get Comments
                $comments_query = "SELECT tc.*, u.first_name, u.last_name, u.profile_pic FROM thread_comments tc JOIN users u ON tc.user_id = u.id WHERE tc.thread_id = '$thread_id' ORDER BY tc.created_at ASC";
                $comments_result = mysqli_query($conn, $comments_query);
            ?>
                <div class="thread-card">
                    <div class="thread-body">
                        <?php if(!empty($row['image'])): ?>
                            <div class="thread-image">
                                <img src="img/threads/<?php echo $row['image']; ?>" alt="Thread Image">
                            </div>
                        <?php endif; ?>

                        <div class="thread-content">
                            <h3 class="thread-title"><?php echo htmlspecialchars($row['content']); ?></h3>
                            <div class="user-info">
                                <img src="img/<?php echo $row['user_pic'] ? $row['user_pic'] : 'default.jpg'; ?>" class="user-avatar-xs">
                                <div>
                                    <h4 class="user-name"><?php echo $row['first_name'] . " " . $row['last_name']; ?></h4>
                                    <span class="post-time"><?php echo date('d M Y', strtotime($row['created_at'])); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="thread-footer">
                        <div class="stats-left">
                            <span><?php echo number_format($row['views']); ?> views</span>
                        </div>
                        <div class="stats-right">
                            <span class="like-count"><?php echo number_format($row['likes']); ?> likes</span>
                            
                            <a href="<?php echo $is_logged_in ? 'like_post.php?id='.$thread_id : 'login.html'; ?>" class="action-link">
                                <i class="<?php echo $is_liked ? 'fa-solid fa-heart liked' : 'fa-regular fa-heart'; ?>"></i>
                            </a>
                            
                            <div class="comment-trigger" onclick="toggleComments(<?php echo $thread_id; ?>)" style="cursor: pointer;">
                                <span><?php echo $total_comments; ?> comments</span>
                                <i class="fa-regular fa-comment-dots action-icon"></i>
                            </div>
                        </div>
                    </div>

                    <div class="comments-section" id="comments-<?php echo $thread_id; ?>" style="display: none;">
                        <?php if(mysqli_num_rows($comments_result) > 0): ?>
                            <div class="comments-list">
                                <?php while($com = mysqli_fetch_assoc($comments_result)): ?>
                                    <div class="comment-item">
                                        <strong><?php echo $com['first_name']; ?>:</strong> <?php echo htmlspecialchars($com['comment']); ?>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else: ?>
                             <p style="font-size: 0.9rem; color: #888; margin-bottom: 10px;">No comments yet.</p>
                        <?php endif; ?>
                        
                        <?php if ($is_logged_in): ?>
                            <form action="comment_post.php" method="POST" class="comment-form">
                                <input type="hidden" name="thread_id" value="<?php echo $thread_id; ?>">
                                <input type="text" name="comment" placeholder="Write a comment..." required autocomplete="off">
                                <button type="submit" name="submit_comment"><i class="fa-solid fa-paper-plane"></i></button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>

            <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <a href="?page=<?php echo max(1, $page - 1); ?>"><i class="fa-solid fa-angles-left"></i></a>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
                <a href="?page=<?php echo min($total_pages, $page + 1); ?>"><i class="fa-solid fa-angles-right"></i></a>
            </div>
            <?php endif; ?>

        </div>
    </div>

    <script src="forum.js"></script>
</body>
</html>