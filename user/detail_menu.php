<?php
include '../config/db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$menu_id = $_GET['id'];

// Pastikan variabel $menu_id ada sebelum menggunakan header
if (empty($menu_id)) {
    header("Location: index.php");
    exit();
}

// Ambil informasi menu
$stmt_menu = $pdo->prepare("SELECT * FROM menus WHERE id = ?");
$stmt_menu->execute([$menu_id]);
$menu = $stmt_menu->fetch(PDO::FETCH_ASSOC);

// Ambil ulasan untuk menu ini dengan status ditampilkan
$stmt_reviews = $pdo->prepare("SELECT * FROM reviews WHERE menu_id = ? AND status = 1");
$stmt_reviews->execute([$menu_id]);
$reviews = $stmt_reviews->fetchAll(PDO::FETCH_ASSOC);

// Proses pengiriman ulasan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $rating = $_POST['rating'];
    $ulasan = $_POST['ulasan'];
    $nama = $_POST['nama'];
    $review_id = 'review-' . time();
    $status = 1;

    $stmt_insert_review = $pdo->prepare("INSERT INTO reviews (id, menu_id, rating, comment, nama, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt_insert_review->execute([$review_id, $menu_id, $rating, $ulasan, $nama, $status]);

    header("Location: detail_menu.php?id=$menu_id");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Detail Menu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .menu-info img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .menu-info p {
            margin: 5px 0;
        }
        .ulasan {
            border-top: 1px solid #ddd;
            padding-top: 20px;
            margin-top: 20px;
        }
        .ulasan h3 {
            margin-bottom: 10px;
        }
        .ulasan .ulasan-item {
            margin-bottom: 10px;
        }
        .ulasan .nama {
            font-weight: bold;
        }
        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #007bff;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        form {
            margin-top: 20px;
        }
        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        form input[type="number"],
        form input[type="text"],
        form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        form button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-family: Arial, sans-serif;
            transition: background-color 0.3s ease;
        }
        form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="menu-info">
        <h1><?= htmlspecialchars($menu['nama']) ?></h1>
        <img src="<?= base_image_url . $menu['image_url'] ?>" alt="<?= $menu['nama'] ?>">
        <p><strong>Harga:</strong> <?= htmlspecialchars($menu['harga']) ?></p>
        <p><strong>Deskripsi:</strong> <?= htmlspecialchars($menu['deskripsi']) ?></p>
        <p><strong>Stok:</strong> <?= htmlspecialchars($menu['stok']) ? 'Tersedia' : 'Kosong' ?></p>
        <p><strong>Kategori:</strong> <?= htmlspecialchars($menu['kategori']) ?></p>
    </div>

    <div class="ulasan">
        <h3>Ulasan</h3>

        <?php if (empty($reviews)): ?>
            <p>Belum ada ulasan untuk menu ini.</p>
        <?php else: ?>
            <?php foreach ($reviews as $review): ?>
                <div class="ulasan-item">
                    <p><span class="nama"><?= htmlspecialchars($review['nama']) ?></span> - <?= htmlspecialchars($review['tanggal_kirim']) ?></p>
                    <p>Rating: <?= htmlspecialchars($review['rating']) ?></p>
                    <p>Ulasan: <?= htmlspecialchars($review['comment']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Form untuk mengirim ulasan -->
        <h3>Kirim Ulasan</h3>
        <form method="post">
            <label for="rating">Rating:</label>
            <input type="number" id="rating" name="rating" min="1" max="5" required>
            <label for="ulasan">Ulasan:</label>
            <textarea id="ulasan" name="ulasan" rows="4" required></textarea>
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required>
            <button type="submit" name="submit">Kirim Ulasan</button>
        </form>
    </div>
    <a href="index.php" class="back-link">Kembali ke Menu Utama</a>
</div>
</body>
</html>
