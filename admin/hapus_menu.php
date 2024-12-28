<?php
include '../config/db.php';
session_start();

// Pastikan admin sudah login
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Pastikan parameter ID menu ada
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$menu_id = $_GET['id'];

// Ambil informasi menu sebelum dihapus
$stmt_menu = $pdo->prepare("SELECT * FROM menus WHERE id = ?");
$stmt_menu->execute([$menu_id]);
$menu = $stmt_menu->fetch(PDO::FETCH_ASSOC);

// Jika menu tidak ditemukan, redirect ke halaman index
if (!$menu) {
    header("Location: index.php");
    exit();
}

// Hapus menu dari database
$stmt_delete = $pdo->prepare("DELETE FROM menus WHERE id = ?");
$stmt_delete->execute([$menu_id]);

// Masukkan entri history
$admin_id = $_SESSION['admin']['id'];
$history_id = 'history-' . time();
$aktivitas = "Hapus menu: " . $menu['nama'];
$stmt_history = $pdo->prepare("INSERT INTO history (id, admin_id, aktivitas) VALUES (?, ?, ?)");
$stmt_history->execute([$history_id, $admin_id, $aktivitas]);

// Redirect kembali ke halaman index
header("Location: index.php");
exit();
?>
