<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // 1. Cari user berdasarkan email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        // 2. Verifikasi Password (Hash vs Input)
        if (password_verify($password, $row['password'])) {
            // Password Benar
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['first_name'] = $row['first_name'];
            
            // Redirect ke halaman dashboard/home setelah login sukses
            echo "<script>
                    alert('Login Berhasil! Selamat Datang " . $row['first_name'] . "');
                    window.location.href = 'home.php'; 
                  </script>";
        } else {
            // Password Salah
            echo "<script>
                    alert('Password salah!');
                    window.location.href = 'login.html';
                  </script>";
        }
    } else {
        // Email tidak ditemukan
        echo "<script>
                alert('Email tidak terdaftar!');
                window.location.href = 'login.html';
              </script>";
    }
}
?>