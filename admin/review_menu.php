<?php
include '../config/db.php';
session_start();

// Logika logout
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

// Ambil ulasan berdasarkan status default (status = 1)
$stmt_reviews = $pdo->prepare("SELECT reviews.*, menus.nama AS menu_name FROM reviews JOIN menus ON reviews.menu_id = menus.id WHERE reviews.status = 1");
$stmt_reviews->execute();
$reviews = $stmt_reviews->fetchAll(PDO::FETCH_ASSOC);

// Proses penyaringan review
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['filter'])) {
    $status = $_POST['status'];
    $stmt_reviews = $pdo->prepare("SELECT reviews.*, menus.nama AS menu_name FROM reviews JOIN menus ON reviews.menu_id = menus.id WHERE reviews.status = ?");
    $stmt_reviews->execute([$status]);
    $reviews = $stmt_reviews->fetchAll(PDO::FETCH_ASSOC);
}

// Proses update status review
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $review_id = $_POST['review_id'];
    $status = isset($_POST['status']) ? 1 : 0;
    $stmt_update = $pdo->prepare("UPDATE reviews SET status = ? WHERE id = ?");
    $stmt_update->execute([$status, $review_id]);

    // Tambahkan entri riwayat
    $history_id = 'history-' . time();
    $admin_id = $_SESSION['admin']['id'];
    $aktivitas = "Mengupdate status review";
    $stmt_history = $pdo->prepare("INSERT INTO history (id, admin_id, aktivitas) VALUES (?, ?, ?)");
    $stmt_history->execute([$history_id, $admin_id, $aktivitas]);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Review</title>
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
    <h1>Review Comments</h1>

    <!-- Form untuk menyaring review -->
    <form method="post" class="filter-form">
        <label for="status">Filter by Status:</label>
        <select name="status" id="status">
            <option <?= isset($_POST['status']) && $_POST['status'] == 1 ? 'selected' : null ?> value="1">Ditampilkan</option>
            <option <?= isset($_POST['status']) && $_POST['status'] == 0 ? 'selected' : null ?> value="0">Tidak Ditampilkan</option>
        </select>
        <input class="action-links" type="submit" name="filter" value="Filter">
    </form>

    <table>
        <thead>
            <tr>
                <th>Nama Menu</th>
                <th>Rating</th>
                <th>Ulasan</th>
                <th>Nama</th>
                <th>Tanggal Kirim</th>
                <th>Ditampilkan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reviews as $review): ?>
                <tr>
                    <form method="post">
                        <input type="hidden" name="review_id" value="<?= htmlspecialchars($review['id']); ?>">
                        <td><?= htmlspecialchars($review['menu_name']) ?></td>
                        <td><?= htmlspecialchars($review['rating']) ?></td>
                        <td><?= htmlspecialchars($review['comment']) ?></td>
                        <td><?= htmlspecialchars($review['nama']) ?></td>
                        <td><?= htmlspecialchars($review['tanggal_kirim']) ?></td>
                        <td><input type="checkbox" name="status" <?= $review['status'] == 1 ? 'checked' : '' ?>></td>
                        <td>
                            <input class="action-links" type="submit" name="update_status" value="Update Status">
                        </td>
                    </form>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
