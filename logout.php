<?php
session_start(); // 1. Mulai session untuk tahu siapa yang sedang login

// 2. Hapus semua variabel session
$_SESSION = [];
session_unset();

// 3. Hancurkan session sepenuhnya
session_destroy();

// 4. Arahkan kembali ke halaman Home
// Karena session sudah hancur, Home akan otomatis menampilkan tombol "LOGIN" lagi.
header("Location: home.php");
exit();
?>