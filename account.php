<?php
session_start();

// 1. Panggil koneksi database
include 'db.php'; 

// 2. Cek koneksi
if (!isset($conn)) {
    die("Error: File db.php tidak terpanggil atau variabel koneksi salah nama.");
}

// 3. Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$id_user = $_SESSION['user_id'];
$message = ""; 

// --- LOGIC UPDATE DATA & FOTO ---
if (isset($_POST['update_profile'])) {
    
    // A. Ambil data teks
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name  = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email      = mysqli_real_escape_string($conn, $_POST['email']);
    $phone      = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $bio        = mysqli_real_escape_string($conn, $_POST['bio']);

    // B. Logic Upload Foto
    // Ambil nama foto lama dulu dari database (sebagai cadangan jika user tidak upload foto baru)
    $query_old = "SELECT profile_pic FROM users WHERE id = '$id_user'";
    $result_old = mysqli_query($conn, $query_old);
    $data_old = mysqli_fetch_assoc($result_old);
    $foto_nama = $data_old['profile_pic']; // Default pakai foto lama

    // Cek apakah user upload file baru?
    if (isset($_FILES['profile_pic']['name']) && $_FILES['profile_pic']['name'] != "") {
        
        $nama_file   = $_FILES['profile_pic']['name'];
        $ukuran_file = $_FILES['profile_pic']['size'];
        $error       = $_FILES['profile_pic']['error'];
        $tmp_name    = $_FILES['profile_pic']['tmp_name'];

        // Cek ekstensi gambar yang dibolehkan
        $ekstensi_valid = ['jpg', 'jpeg', 'png'];
        $ekstensi_gambar = explode('.', $nama_file);
        $ekstensi_gambar = strtolower(end($ekstensi_gambar));

        if (!in_array($ekstensi_gambar, $ekstensi_valid)) {
            $message = "Error: Format file harus JPG, JPEG, atau PNG!";
        } elseif ($ukuran_file > 2000000) { // Maksimal 2MB
            $message = "Error: Ukuran file terlalu besar (Max 2MB)!";
        } else {
            // Generate nama baru unik agar tidak menimpa file orang lain
            // Contoh hasil: 6643a_profil.jpg
            $nama_file_baru = uniqid() . '.' . $ekstensi_gambar;
            
            // Pindahkan file ke folder 'img/'
            if (move_uploaded_file($tmp_name, 'img/' . $nama_file_baru)) {
                $foto_nama = $nama_file_baru; // Update variabel nama foto dengan yang baru
            } else {
                $message = "Gagal mengupload gambar.";
            }
        }
    }

    // C. Query Update (Hanya jalan jika tidak ada error upload)
    if (strpos($message, "Error") === false) {
        $query_update = "UPDATE users SET 
                            first_name = '$first_name', 
                            last_name = '$last_name', 
                            email = '$email', 
                            phone_number = '$phone',
                            bio = '$bio',
                            profile_pic = '$foto_nama' 
                         WHERE id = '$id_user'";

        if (mysqli_query($conn, $query_update)) {
            $message = "Profile updated successfully!";
            $_SESSION['first_name'] = $first_name; // Update session nama
        } else {
            $message = "Update failed: " . mysqli_error($conn);
        }
    }
}

// --- AMBIL DATA TERBARU UNTUK DITAMPILKAN ---
$query = "SELECT * FROM users WHERE id = '$id_user'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Cek foto, kalau kosong pakai default
$tampil_foto = !empty($data['profile_pic']) ? $data['profile_pic'] : 'default.jpg';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - Edunext</title>
    <link rel="stylesheet" href="account.css">
    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@400;700&family=Lalezar&family=Notable&family=Josefin+Sans:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <header class="headerbar">
        <img src="img/header/Group 17.png" class="headerlogo" alt="Logo">
        <div class="headerbarmiddle">
            <a href="home.php">Home</a>
            <a href="aboutus.php">About Us</a>
            <a href="forum.php">Forum</a>
        </div>
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="profile-header">
            <a href="account.php"><img src="img/<?php echo $tampil_foto; ?>" alt="Profile"></a>
        </div>
    </header>

    <div class="mobile-menu" id="mobileMenu">
        <a href="./home.php">Home</a>
        <a href="./aboutus.php">About Us</a>
        <a href="./forum.php">Forum</a>
    </div>

    <div class="main-container">
        
        <form class="account-form" method="POST" action="" enctype="multipart/form-data">

            <div class="left-section">
                <h1 class="welcome-text">
                    WELCOME,<br>
                    <span class="user-name">
                    <?php echo strtoupper($_SESSION['first_name']); ?>!
                    </span>
                </h1>

                <?php if ($message != ""): ?>
                    <div class="message-box" style="padding: 15px; margin-bottom: 20px; background-color: <?php echo (strpos($message, 'Error') !== false) ? '#f8d7da' : '#d1e7dd'; ?>; color: <?php echo (strpos($message, 'Error') !== false) ? '#721c24' : '#0f5132'; ?>; border-radius: 8px;">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <div class="name-row">
                    <div class="form-group name-col">
                        <label>First Name</label>
                        <div class="input-wrapper">
                            <input type="text" name="first_name" value="<?php echo htmlspecialchars($data['first_name']); ?>" required>
                            <span class="edit-icon">&#9998;</span> 
                        </div>
                    </div>
                    
                    <div class="form-group name-col">
                        <label>Last Name</label>
                        <div class="input-wrapper">
                            <input type="text" name="last_name" value="<?php echo htmlspecialchars($data['last_name']); ?>" required>
                            <span class="edit-icon">&#9998;</span> 
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <div class="input-wrapper">
                        <input type="email" name="email" value="<?php echo htmlspecialchars($data['email']); ?>">
                        <span class="edit-icon">&#9998;</span>
                    </div>
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <div class="input-wrapper">
                        <input type="text" name="phone_number" value="<?php echo htmlspecialchars($data['phone_number']); ?>">   
                        <span class="edit-icon">&#9998;</span>
                    </div>
                </div>

                <div class="bottom-actions">
                    <div class="links-group">
                        <a href="premium.php" class="premium-link">Activate Premium Account</a>
                        <br>
                        <a href="logout.php" class="logout-link">Log Out</a>
                    </div>
                    
                    <button type="submit" name="update_profile" class="btn-save">
                        SAVE. <span class="arrow">&rsaquo;</span>
                    </button>
                </div>
            </div>

            <div class="vertical-divider"></div>

            <div class="right-section">
                <div class="profile-card">
                    <div class="image-container">
                        <img src="img/<?php echo $tampil_foto; ?>" id="photoPreview" alt="Profile Photo">
                        
                        <input type="file" name="profile_pic" id="fileInput" accept="image/*" style="display: none;" onchange="previewImage(event)">
                        
                        <button type="button" class="edit-photo-btn" onclick="document.getElementById('fileInput').click()">&#9998;</button>
                    </div>
                    <div class="bio-section">
                        <textarea name="bio" placeholder="Say something about yourself..."><?php echo isset($data['bio']) ? htmlspecialchars($data['bio']) : ''; ?></textarea>
                    </div>
                </div>
            </div>

        </form>

    </div>

    <div class="yellow-box"></div>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('photoPreview');
                output.src = reader.result;
            };
            if(event.target.files[0]){
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    </script>
    <script src="hamburger.js"></script>
</body>
</html>