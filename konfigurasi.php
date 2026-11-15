<?php
// konfigurasi.php
// File konfigurasi: koneksi database dan fungsi bantu.

// ----- Koneksi Database (PDO) -----
$host = '127.0.0.1';
$dbname = 'catatan';
$user = 'root';
$pass = '';

try {
    // Koneksi ke server MySQL dulu (belum pakai database)
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Buat database jika belum ada, lalu pakai database itu
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `$dbname`");

    // Buat tabel users jika belum ada (untuk akun login)
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Buat tabel notes jika belum ada (untuk isi catatan user)
    $pdo->exec("CREATE TABLE IF NOT EXISTS notes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        judul VARCHAR(100) NOT NULL,
        isi TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

} catch (PDOException $e) {
    die('Koneksi gagal: ' . $e->getMessage());
}

// ----- Session -----
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ----- Fungsi Bantu -----

// Cek apakah user sudah login
function is_logged_in()
{
    return isset($_SESSION['user_id']);
}

// Paksa login: jika belum login, redirect ke masuk.php
function require_login()
{
    if (!is_logged_in()) {
        header('Location: masuk.php');
        exit;
    }
}

// Redirect sederhana
function redirect(string $url)
{
    header("Location: $url");
    exit;
}
?>