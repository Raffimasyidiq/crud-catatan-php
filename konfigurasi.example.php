<?php
// Contoh file konfigurasi
$host = 'localhost';
$dbname = 'nama_database_kamu';
$username = 'root';
$password = ''; // Kosongkan password lokal

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}