<?php
include '../config/db.php';
session_start();

if (isset($_SESSION['admin'])) {
    $admin_id = $_SESSION['admin']['id'];
    $username = $_SESSION['admin']['username'];

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ? AND id = ?");
    $stmt->execute([$username, $admin_id]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        header("Location: index.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adminId = 'admin-' . time();
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $password = md5($_POST['password']);
    
    $stmt = $pdo->prepare("INSERT INTO admins (id, username, nama, password) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$adminId, $username, $nama, $password])) {
        // Tambahkan entri riwayat
        $history_id = 'history-' . time();
        $aktivitas = "Admin baru $username telah dibuat";
        $stmt_history = $pdo->prepare("INSERT INTO history (id, admin_id, aktivitas) VALUES (?, ?, ?)");
        $stmt_history->execute([$history_id, $adminId, $aktivitas]);

        echo "Registration successful!";
    } else {
        echo "Error: Could not register admin.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registarsi</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
        <form class="input-form" method="post">
            <h1>Registrasi</h1>
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="text" name="nama" placeholder="nama" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <div class="space-between">
                <a class="cancel-button" href="login.php">Kembali</a>
                <button class="submit-button" type="submit">Registrasi</button>
            </div>
        </form>
        <!-- Error message -->
        <?php if(isset($error)) { ?>
            <p class="error"><?= $error ?></p>
        <?php } ?>
</body>
</html>