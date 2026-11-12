<?php
// daftar php
// Halaman pendaftaran user baru.

require_once 'konfigurasi.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    if ($username === '' || $password === '') {
        $errors[] = 'Username dan password wajib diisi.';
    } elseif (strlen($username) < 3) {
        $errors[] = 'Username minimal 3 karakter.';
    } elseif (strlen($password) < 4) {
        $errors[] = 'Password minimal 4 karakter.';
    } elseif ($password !== $password2) {
        $errors[] = 'Konfirmasi password tidak cocok.';
    } else {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $errors[] = 'Username sudah digunakan.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
            $stmt->execute([$username, $hash]);
            $success = 'Registrasi berhasil! Silakan login.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f7f7f8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            background-color: #ffffff;
            padding: 32px;
            width: 100%;
            max-width: 420px;
            border: 1px solid #e4e4e7;
            border-radius: 10px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }

        h2 {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
            text-align: center;
            margin-bottom: 24px;
        }

        .error-msg {
            background-color: #fef2f2;
            color: #991b1b;
            padding: 10px;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 16px;
            border: 1px solid #f87171;
        }

        .success-msg {
            background-color: #f0fdf4;
            color: #166534;
            padding: 10px;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 16px;
            border: 1px solid #4ade80;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            font-size: 14px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            margin-bottom: 16px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #111827;
            box-shadow: 0 0 0 3px rgba(17, 24, 39, 0.1);
        }

        button[type="submit"] {
            width: 100%;
            background-color: #111827;
            color: white;
            padding: 12px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 4px;
            transition: background-color 0.2s;
        }

        button[type="submit"]:hover {
            background-color: #1f2937;
        }

        .container p:last-child {
            text-align: center;
            font-size: 13px;
            color: #6b7280;
            margin-top: 20px;
        }

        .container p:last-child a {
            color: #111827;
            text-decoration: none;
            font-weight: 600;
        }

        .container p:last-child a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Daftar Akun</h2>

        <?php foreach ($errors as $e): ?>
            <div class="error-msg"><?= htmlspecialchars($e) ?></div>
        <?php endforeach; ?>

        <?php if ($success): ?>
            <div class="success-msg"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="post" action="">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <label for="password2">Konfirmasi Password</label>
            <input type="password" id="password2" name="password2" required>
            
            <button type="submit">Daftar</button>
        </form>

        <p>Sudah punya akun? <a href="masuk.php">Login di sini</a></p>
    </div>
</body>
</html>