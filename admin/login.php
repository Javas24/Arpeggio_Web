<?php
session_start();

// Jika pengguna sudah login, arahkan ke halaman index
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

include '../config/db.php';

// Logika login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($admin) {
        $_SESSION['admin']['username'] = $admin['username'];
        $_SESSION['admin']['id'] = $admin['id'];
        
        // Mencatat aktivitas login ke tabel history
        $history_id = 'history-' . time();
        $aktivitas = "Telah melakukan login";
        $admin_id = $admin['id'];
        
        $stmt_history = $pdo->prepare("INSERT INTO history (id, admin_id, aktivitas) VALUES (?, ?, ?)");
        $stmt_history->execute([$history_id, $admin_id, $aktivitas]);
        
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
        <form class="input-form" method="post">
            <h1>Login</h1>
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <p>Belum memiliki akun? <a href="register.php" class="input-link">Daftar</a></p>
            <button type="submit">Login</button>
        </form>
        <!-- Error message -->
        <?php if(isset($error)) { ?>
            <p class="error"><?= $error ?></p>
        <?php } ?>
</body>
</html>
