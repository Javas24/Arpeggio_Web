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

// Ambil semua menu dan nama admin yang terkait
if (isset($_POST['filter'])) {
    $status = $_POST['status'];
    if ($status === '1' || $status === '0') {
        $stmt = $pdo->prepare("SELECT menus.*, admins.nama AS admin_name FROM menus JOIN admins ON menus.admin_id = admins.id WHERE menus.status = ?");
        $stmt->execute([$status]);
    } else {
        $stmt = $pdo->prepare("SELECT menus.*, admins.nama AS admin_name FROM menus JOIN admins ON menus.admin_id = admins.id");
        $stmt->execute();
    }
} else {
    $stmt = $pdo->prepare("SELECT menus.*, admins.nama AS admin_name FROM menus JOIN admins ON menus.admin_id = admins.id");
    $stmt->execute();
}

$menus = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Menu Admin</title>
    <style>
    </style>
</head>
<body>
    <!-- Navbar -->
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
        <h1>Menus</h1>

		<div class="space-between">
        <a href="create_menu.php" class="action-links button">Menambahkan Menu</a>

        <form class="filter-form" method="post">
            <label for="status">Filter by Status:</label>
            <select name="status" id="status">
                <option value="">All</option>
                <option <?= isset($_POST['status']) && $_POST['status'] == '1' ? 'selected' : '' ?> value="1">Ditampilkan</option>
                <option <?= isset($_POST['status']) && $_POST['status'] == '0' ? 'selected' : '' ?> value="0">Tidak Ditampilkan</option>
            </select>
            <input type="submit" class="button" name="filter" value="Filter">
        </form>
		</div>

        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Deskripsi</th>
                    <th>Image URL</th>
                    <th>Stok</th>
                    <th>Kategori</th>
                    <th>Admin</th>
                    <th>Status</th>
                    <th>Ubah</th>
                    <th>Hapus</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($menus as $menu): ?>
                <tr>
                    <td><?= htmlspecialchars($menu['nama']) ?></td>
                    <td><?= htmlspecialchars($menu['harga']) ?></td>
                    <td><?= htmlspecialchars($menu['deskripsi']) ?></td>
                    <td><img src="/uas/<?= htmlspecialchars($menu['image_url']) ?>"></td>
                    <td><?= htmlspecialchars($menu['stok']) ?></td>
                    <td><?= htmlspecialchars($menu['kategori']) ?></td>
                    <td><?= htmlspecialchars($menu['admin_name']) ?></td>
                    <td><?= $menu['status'] ? 'Ditampilkan' : 'Tidak Ditampilkan' ?></td>
                    <td>
                        <a href="edit_menu.php?id=<?= htmlspecialchars($menu['id']) ?>" class="action-links">Edit</a>
                    </td>
                    <td>
                    <a href="hapus_menu.php?id=<?= htmlspecialchars($menu['id']) ?>" class="action-links">Hapus</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
