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

if (isset($_GET['logout'])) {
    // Ambil ID admin yang sedang login
    $admin_id = $_SESSION['admin']['id'];

    // Masukkan entri history
	$history_id = 'history-' . time();
    $aktivitas = "Logout";
    $stmt_history = $pdo->prepare("INSERT INTO history (id, admin_id, aktivitas) VALUES (?, ?, ?)");
    $stmt_history->execute([$history_id, $admin_id, $aktivitas]);

    // Unset session admin
    unset($_SESSION['admin']);

    // Redirect ke halaman login
    header("Location: login.php");
    exit();
}

$stmt_history = $pdo->query("SELECT history.*, admins.nama AS admin_name FROM history JOIN admins ON history.admin_id = admins.id ORDER BY history.waktu DESC");
$history = $stmt_history->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>History Aktivitas Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="space-between">
    <div class="menu-nav">
        <a href="index.php">Menu</a>
        <a href="review_menu.php">Review</a>
        <a href="history.php">History</a>
    </div>
    <div class="log-out-nav">
        <a href="?logout" class="logout-btn">Logout</a>
    </div>
</nav>
<div class="container">
    <h1>History Aktivitas Admin</h1>
    <table>
        <thead>
            <tr>
                <th>Nama Admin</th>
                <th>Aktivitas</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($history as $entry): ?>
                <tr>
                    <td><?= htmlspecialchars($entry['admin_name']) ?></td>
                    <td><?= htmlspecialchars($entry['aktivitas']) ?></td>
                    <td><?= htmlspecialchars($entry['waktu']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
