<?php
include '../config/db.php';

// Ambil semua menu dengan status ditampilkan
$stmt = $pdo->query("SELECT * FROM menus WHERE status = 1");
$menus = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fungsi untuk mengambil rating rata-rata dari tabel ulasan
function getAverageRating($pdo, $menu_id) {
    $stmt = $pdo->prepare("SELECT AVG(rating) as average_rating FROM reviews WHERE menu_id = ? AND status = 1");
    $stmt->execute([$menu_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['average_rating'];
}
function formatRupiah($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Menu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <header>
        <div class="logo">
        <img src="../assets/loput.jpeg" alt="">
        </div>
        <nav class="navbar" id="navbar">
            <ul>
                <li><a href="#tentang">Tentang</a></li>
                <li><a href="#makanan">Makanan</a></li>
                <li><a href="#minuman">Minuman</a></li>
            </ul>
        </nav>
        <button id="hamburgerButton">☰</button>
    </header>

    <main>
        <section class="tentang" id="tentang">
            <div class="image">
                <img src="../assets/loput.jpeg" alt="">
            </div>
            <div class="content">
                <h3>We Are Open!</h3>
                <p>
                Kopi Membawa Berkah adalah tempat yang sempurna untuk menikmati kopi dan minuman tradisional lainnya. Kami tidak hanya menyajikan beragam kopi berkualitas, tetapi juga minuman non kopi yang lezat. Nikmati juga menu makanan khas yang cocok disantap bersama minuman tradisional kami. Dengan jam operasional Senin-Jumat, 07.00-22.00, kami siap menyambut Anda dengan hangat. Rasakan kehangatan dan kenikmatan di setiap tegukan dan suapan di Kopi Membawa Berkah.
            </p>
                <a class="button" href="#makanan">Lebih lanjut</a>
            </div>
        </section>

        <section class="makanan" id="makanan">
            <div class="heading">
                <h3>Makanan</h3>
                <h2>Makanan Terlezat</h2>
            </div>
            <div class="card-container">
                <?php foreach ($menus as $menu): ?>
                    <?php if ($menu['kategori'] === 'makanan') { ?>
                    <div class="card">
                        <div class="image">
                            <img src="<?= base_image_url . $menu['image_url'] ?>" alt="<?= htmlspecialchars($menu['nama']) ?>">
                        </div>
                        <div class="content">
                            <h2><?= htmlspecialchars($menu['nama']) ?></h2>
                            <?php $average_rating = getAverageRating($pdo, $menu['id']); ?>
                            <p class="rating">Rating: <?= $average_rating ? number_format($average_rating, 1) : 'Belum memiliki rating' ?></p>
                            <p class="stok">Stok: <?= htmlspecialchars($menu['stok']) ? 'Tersedia' : 'Kosong' ?></p>
                            <p class="deskripsi"><?= htmlspecialchars($menu['deskripsi']) ?></p>
                            <div class="details">
                                <span class="harga"><?= formatRupiah(htmlspecialchars($menu['harga'])) ?></span>
                                <a class="button" href="detail_menu.php?id=<?= htmlspecialchars($menu['id']) ?>">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                <?php endforeach; ?>
            </div>
        </section>
        
        <section class="minuman" id="minuman">
            <div class="heading">
                <h3>Minuman</h3>
                <h2>Minuman Tersegar</h2>
            </div>
            <div class="card-container">
            <?php foreach ($menus as $menu): ?>
                    <?php if ($menu['kategori'] === 'minuman') { ?>
                    <div class="card">
                        <div class="image">
                            <img src="<?= base_image_url . $menu['image_url'] ?>" alt="<?= htmlspecialchars($menu['nama']) ?>">
                        </div>
                        <div class="content">
                            <h2><?= htmlspecialchars($menu['nama']) ?></h2>
                            <?php $average_rating = getAverageRating($pdo, $menu['id']); ?>
                            <p class="rating">Rating: <?= $average_rating ? number_format($average_rating, 1) : 'Belum memiliki rating' ?></p>
                            <p class="stok">Stok: <?= htmlspecialchars($menu['stok']) ? 'Tersedia' : 'Kosong' ?></p>
                            <p class="deskripsi"><?= htmlspecialchars($menu['deskripsi']) ?></p>
                            <div class="details">
                                <span class="harga"><?= formatRupiah(htmlspecialchars($menu['harga'])) ?></span>
                                <a class="button" href="detail_menu.php?id=<?= htmlspecialchars($menu['id']) ?>">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <footer class="footer">
      <div class="box-container">
        <div class="box">
          <h3>lokasi</h3>
          <a href="#">jawa Timur</a>
          <a href="#">bali</a>
          <a href="#">jawa Barat</a>
          <a href="#">yogyakarta</a>
          <a href="#">jawa Tengah</a>
        </div>
        
        <div class="box">
          <h3>link alternatif</h3>
          <a href="#home">beranda</a>
          <a href="#menu">menu</a>
          <a href="#about">tentang</a>
          <a href="#drink">minuman</a>
          <a href="#review">ulasan</a>
        </div>
        
        <div class="box">
          <h3>kontak</h3>
          <a href="#">+123-456-789</a>
          <a href="#">+123-456-333</a>
          <a href="#">javas@gmail.com</a>
          <a href="#">deva@gmail.com</a>
        </div>
        
        <div class="box">
          <h3>follow kita</h3>
          <a href="#">facebook</a>
          <a href="#">twitter</a>
          <a href="#">instagram</a>
          <a href="#">linkedin</a>
        </div>
      </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const hamburgerButton = document.getElementById("hamburgerButton");
            const navbar = document.getElementById("navbar");
            const sections = document.querySelectorAll('section');

            hamburgerButton.addEventListener("click", function () {
                navbar.classList.toggle("open");
            });

            document.addEventListener("click", function (event) {
                if (!navbar.contains(event.target) && event.target !== hamburgerButton) {
                    navbar.classList.remove("open");
                }
            });

            window.addEventListener("scroll", function () {
                navbar.classList.remove("open");
            });
        });
    </script>
</body>
</html>
