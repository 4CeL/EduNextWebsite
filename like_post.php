<?php
session_start();
include 'db.php';

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $thread_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // 1. Cek apakah user sudah like thread ini?
    $check_query = "SELECT * FROM thread_likes WHERE user_id = '$user_id' AND thread_id = '$thread_id'";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        // SUDAH LIKE -> Lakukan UNLIKE (Hapus data)
        $sql = "DELETE FROM thread_likes WHERE user_id = '$user_id' AND thread_id = '$thread_id'";
        mysqli_query($conn, $sql);
        
        // Kurangi counter likes di tabel threads
        mysqli_query($conn, "UPDATE threads SET likes = likes - 1 WHERE id = '$thread_id'");
    } else {
        // BELUM LIKE -> Lakukan LIKE (Simpan data)
        $sql = "INSERT INTO thread_likes (user_id, thread_id) VALUES ('$user_id', '$thread_id')";
        mysqli_query($conn, $sql);
        
        // Tambah counter likes di tabel threads
        mysqli_query($conn, "UPDATE threads SET likes = likes + 1 WHERE id = '$thread_id'");
    }

    // Kembali ke halaman forum
    header("Location: forum.php"); 
} else {
    header("Location: login.html");
}
?>