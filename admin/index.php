<?php
include '../config/db.php';
session_start();

// Logika logout
if (isset($_GET['logout'])) {
    $admin_id = $_SESSION['admin']['id'];

    $history_id = 'history-' . time();
    $aktivitas = "Logout";
    $stmt_history = $pdo->prepare("INSERT INTO history (id, admin_id, aktivitas) VALUES (?, ?, ?)");
    $stmt_history->execute([$history_id, $admin_id, $aktivitas]);

    unset($_SESSION['admin']);

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

$stmt = $pdo->prepare("
    SELECT guitars.*, admins.nama AS admin_name
    FROM guitars
    JOIN admins ON guitars.admin_id = admins.id
");
$stmt->execute();

$guitars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Panel Admin</title>
    <style>
    </style>
</head>
<body>
    <nav class="space-between">
		<div class="menu-nav">
			<a href="index.php">Produk</a>
			<a href="history.php">History</a>
		</div>
		<div class="log-out-nav">
			<a href="?logout" class="logout-btn">Logout</a>
		</div>
    </nav>

    <div class="container">
        <h1>Produk</h1>

		<div class="space-between">
        <a href="create_produk.php" class="action-links button">Menambahkan Produk</a>
		</div>

        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Deskripsi</th>
                    <th>Image</th>
                    <th>Stok</th>
                    <th>Admin</th>
                    <th>Ubah</th>
                    <th>Hapus</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($guitars as $produk): ?>
                <tr>
                    <td><?=htmlspecialchars($produk['nama'])?></td>
                    <td><?=htmlspecialchars($produk['harga'])?></td>
                    <td><?=htmlspecialchars($produk['deskripsi'])?></td>
                    <td><img src="/uas/<?=htmlspecialchars($produk['image_url'])?>"></td>
                    <td><?=htmlspecialchars($produk['stok'])?></td>
                    <td><?=htmlspecialchars($produk['admin_name'])?></td>
                    <td>
                        <a href="edit_produk$produk.php?id=<?=htmlspecialchars($produk['id'])?>" class="action-links">Edit</a>
                    </td>
                    <td>
                    <a href="hapus_produk$produk.php?id=<?=htmlspecialchars($produk['id'])?>" class="action-links">Hapus</a></td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</body>
</html>