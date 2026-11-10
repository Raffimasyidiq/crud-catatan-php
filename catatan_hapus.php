<?php
// catatan_hapus.php - DELETE catatan.
require_once 'konfigurasi.php';
require_login();

// Ambil id dari URL, (int) mencegah nilai aneh-aneh.
$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {
    // Hanya hapus jika catatan itu milik user yang login (keamanan).
    $stmt = $pdo->prepare('DELETE FROM notes WHERE id = ? AND user_id = ?');
    $stmt->execute([$id, $_SESSION['user_id']]);
}

redirect('catatan.php');
?>