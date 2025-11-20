<?php
session_start();
include 'db.php';

if (isset($_POST['submit_comment']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $thread_id = $_POST['thread_id'];
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    if (!empty($comment)) {
        // Masukkan komentar ke database
        $sql = "INSERT INTO thread_comments (user_id, thread_id, comment) VALUES ('$user_id', '$thread_id', '$comment')";
        mysqli_query($conn, $sql);
    }

    header("Location: forum.php");
} else {
    header("Location: login.html");
}
?>