<?php
// beranda.php
// Halaman yang hanya bisa diakses setelah login.

require_once 'konfigurasi.php';
require_login(); // jika belum login, redirect ke masuk.php

$username = $_SESSION['username'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f7f7f8;
            color: #111827;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #ffffff;
            padding: 32px;
            width: 100%;
            max-width: 480px;
            border: 1px solid #e4e4e7;
            border-radius: 10px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            text-align: center;
        }

        h2 {
            font-size: 22px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 12px;
        }

        p {
            font-size: 14px;
            color: #4b5563;
            line-height: 1.5;
            margin-bottom: 24px;
        }

        .menu-grid {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .btn-primary {
            display: block;
            width: 100%;
            background-color: #111827;
            color: white;
            padding: 12px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.2s;
        }

        .btn-primary:hover {
            background-color: #1f2937;
        }

        .btn-logout {
            display: block;
            width: 100%;
            background-color: #ffffff;
            color: #dc2626;
            padding: 12px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid #fca5a5;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .btn-logout:hover {
            background-color: #fef2f2;
        }

        .username {
            color: #2563eb; /* Mengubah warna biru agar terlihat lebih modern */
            font-weight: 600;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Selamat datang, <span class="username"><?= htmlspecialchars($username) ?></span>!</h2>
    <p>Anda berhasil login. Ini adalah halaman utama dashboard Anda.</p>
    
    <div class="menu-grid">
        <a href="catatan.php" class="btn-primary">Kelola Catatan (CRUD)</a>
        <a href="keluar.php" class="btn-logout">Logout</a>
    </div>
</div>
</body>
</html>