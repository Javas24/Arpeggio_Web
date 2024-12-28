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
    $id = 'produk-' . time();
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];

    if ($harga <= 0 || $stok < 0) {
        echo "Harga dan stok harus bernilai positif.";
        exit();
    }

    $target_dir = "../assets/guitar/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_mime_types = ['image/jpeg', 'image/png', 'image/gif'];
    $file_mime_type = mime_content_type($_FILES['image']['tmp_name']);

    if (!in_array($file_mime_type, $allowed_mime_types)) {
        echo "File harus berupa gambar (JPEG, PNG, GIF).";
        $uploadOk = 0;
    }

    if ($uploadOk && move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $image_url = 'assets/guitar/' . basename($_FILES["image"]["name"]);
        $stmt = $pdo->prepare("INSERT INTO produk_gitar (nama, harga, deskripsi, image_url, stok, admin_id) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$nama, $harga, $deskripsi, $image_url, $stok, $admin_id])) {
            $history_id = 'history-' . time();
            $aktivitas = "Menambahkan produk baru";
            $stmt_history = $pdo->prepare("INSERT INTO history (id, admin_id, aktivitas) VALUES (?, ?, ?)");
            $stmt_history->execute([$history_id, $admin_id, $aktivitas]);

            header("Location: index.php");
        } else {
            echo "Error: Could not create produk.";
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menambahkan Produk</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <form class="input-form" method="post" enctype="multipart/form-data">
        <h1>Menambahkan Produk</h1>
        Nama:<br>
        <input type="text" placeholder="Nama produk" name="nama" required><br>
        Harga:<br>
        <input type="number" placeholder="Harga produk" name="harga" required><br>
        Deskripsi:<br>
        <textarea name="deskripsi" placeholder="Deskripsi produk" required></textarea><br>
        Image:<br>
        <input type="file" name="image" required><br>
        Stok:<br>
        <input type="number" placeholder="Jumlah stok" name="stok" required><br>
        <div class="space-between">
            <a class="cancel-button" href="index.php">Kembali</a>
            <button class="submit-button" type="submit">Tambahkan</button>
        </div>
    </form>
</body>
</html>
