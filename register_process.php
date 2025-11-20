<?php
include 'db.php'; // Pastikan file koneksi database ada

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Ambil data dan bersihkan (Sanitize)
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name  = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email      = mysqli_real_escape_string($conn, $_POST['email']);
    $phone      = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $password   = mysqli_real_escape_string($conn, $_POST['password']);

    // 2. Cek apakah email sudah terdaftar sebelumnya?
    $check_email = "SELECT * FROM users WHERE email = '$email'";
    $result_check = mysqli_query($conn, $check_email);

    if (mysqli_num_rows($result_check) > 0) {
        // Jika email sudah ada, beri peringatan dan kembali ke register.html
        echo "<script>
                alert('Email sudah terdaftar! Gunakan email lain.'); 
                window.history.back();
              </script>";
    } else {
        // 3. Jika email aman, Enkripsi Password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // 4. Insert Data
        // Kita masukkan 'default.jpg' ke kolom profile_pic agar akun baru punya foto default
        $sql = "INSERT INTO users (first_name, last_name, email, password, phone_number, profile_pic) 
                VALUES ('$first_name', '$last_name', '$email', '$hashed_password', '$phone', 'default.jpg')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>
                    alert('Registrasi Berhasil! Silakan Login.'); 
                    window.location.href='login.html';
                  </script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
}
?>