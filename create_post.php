<?php
session_start();
include 'db.php';

if (isset($_POST['submit_thread']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $image_name = NULL;

    // Handle Upload Gambar (Opsional)
    if (!empty($_FILES['thread_image']['name'])) {
        $target_dir = "img/threads/";
        // Pastikan folder ada, kalau belum buat manual
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_ext = strtolower(pathinfo($_FILES["thread_image"]["name"], PATHINFO_EXTENSION));
        $image_name = uniqid() . '.' . $file_ext;
        $target_file = $target_dir . $image_name;

        move_uploaded_file($_FILES["thread_image"]["tmp_name"], $target_file);
    }

    // Insert ke Database
    $sql = "INSERT INTO threads (user_id, content, image) VALUES ('$user_id', '$content', '$image_name')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: forum.php"); // Balik ke forum setelah sukses
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: login.html"); // Kalau belum login coba post
}
?>