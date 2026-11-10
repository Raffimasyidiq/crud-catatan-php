<?php
// index.php - halaman utama, redirect ssesuai status login.

require_once 'konfigurasi.php';
if (is_logged_in()) {
    redirect('beranda.php');
} else {
    redirect('masuk.php');
}
?>