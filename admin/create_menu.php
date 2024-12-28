<?php
include '../config/db.php';
session_start();

if (!isset($_SESSION['admin'])) {
    $admin_id = $_SESSION['admin']['id'];
    $username = $_SESSION['admin']['username'];
    
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ? AND id = ?");
    $stmt->execute([$username, $admin_id]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$admin) {
        unset($_SESSION['admin']);
        header("Location: login.php");
        exit();
    }
}

$admin_id = $_SESSION['admin']['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];

    // Handle image upload
    $target_dir = "../assets/images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_url = 'assets/images/' . basename($_FILES["image"]["name"]);

            $stmt = $pdo->prepare("INSERT INTO guitars (nama, harga, deskripsi, image_url, stok, admin_id) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$nama, $harga, $deskripsi, $image_url, $stok, $admin_id])) {
                // Tambahkan entri riwayat
                $history_id = 'history-' . time();
                $aktivitas = "Menambahkan gitar baru";
                $stmt_history = $pdo->prepare("INSERT INTO history (id, admin_id, aktivitas) VALUES (?, ?, ?)");
                $stmt_history->execute([$history_id, $admin_id, $aktivitas]);

                header("Location: index.php");
            } else {
                echo "Error: Could not create guitar entry.";
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menambahkan Gitar</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <form class="input-form" method="post" enctype="multipart/form-data">
        <h1>Menambahkan Gitar</h1>
        Nama:<br>
        <input type="text" placeholder="Nama gitar" name="nama" required><br>
        Harga:<br>
        <input type="number" placeholder="Harga gitar" name="harga" required><br>
        Deskripsi:<br>
        <textarea name="deskripsi" placeholder="Deskripsi gitar" required></textarea><br>
        Image:<br>
        <input type="file" name="image" required><br>
        Stok:<br>
        <input type="number" placeholder="Jumlah stok" name="stok" required><br>
        <button type="submit">Tambahkan</button>
    </form>
</body>
</html>
