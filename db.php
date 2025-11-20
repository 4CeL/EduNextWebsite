<?php
$host = "localhost";
$user = "root";
$pass = ""; // Kosongkan jika pakai XAMPP default, atau isi password root kamu
$db_name = "edunext_db";

$conn = mysqli_connect($host, $user, $pass, $db_name);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>