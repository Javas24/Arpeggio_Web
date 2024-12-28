<?php
include '../config/db.php';

$stmt = $pdo->query("SELECT * FROM produk_gitar");
$produk_gitar = $stmt->fetchAll(PDO::FETCH_ASSOC);

function formatRupiah($angka)
{
    return "Rp " . number_format($angka, 0, ',', '.');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Produk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="../assets/Logo.png" alt="">
        </div>
        <nav class="navbar" id="navbar">
            <ul>
                <li><a href="#tentang">Tentang</a></li>
                <li><a href="#gitar">Produk</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="tentang" id="tentang">
            <div class="image">
                <img src="../assets/Logo.png" alt="">
            </div>
            <div class="content">
                <h3>We Are Open!</h3>
                <p>
                    Arpeggio adalah toko alat musik yang menjadi surga bagi pecinta gitar. Menawarkan beragam koleksi gitar dari berbagai merek ternama, Arpeggio menghadirkan kualitas terbaik untuk semua jenis pemain, dari pemula hingga profesional. Dengan pelayanan ramah dan staf yang ahli, Arpeggio siap membantu Anda menemukan gitar yang sesuai dengan kebutuhan Anda.
                </p>
            </div>
        </section>

        <section class="gitar" id="gitar">
            <div class="heading">
                <h3>Gitar</h3>
                <h2>Terpopuler</h2>
            </div>
            <div class="card-container">
                <?php foreach ($produk_gitar as $produk): ?>
                    <div class="card">
                        <div class="image">
                            <img src="<?=base_image_url . $produk['image_url']?>" alt="<?=htmlspecialchars($produk['nama'])?>">
                        </div>
                        <div class="content">
                            <h2><?=htmlspecialchars($produk['nama'])?></h2>
                            <p class="stok">Stok: <?=htmlspecialchars($produk['stok']) ? 'Tersedia' : 'Kosong'?></p>
                            <p class="deskripsi"><?=htmlspecialchars($produk['deskripsi'])?></p>
                            <div class="details">
                                <span class="harga"><?=formatRupiah(htmlspecialchars($produk['harga']))?></span>
                                <a class="button" href="detail_menu.php?id=<?=htmlspecialchars($produk['id'])?>">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <p>&copy; <?=date("Y");?> Arpeggio Guitar Store. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
