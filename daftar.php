<?php
// daftar php
// Halaman pendaftaran user baru.

require_once 'konfigurasi.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Ambil input dari form.
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    // 2. Validasi sederhana
    if ($username === '' || $password === '') {
        $errors[] = 'Username dan password wajib diisi.';
    } elseif (strlen($username) < 3) {
        $errors[] = 'Username minimal 3 karakter.';
    } elseif (strlen($password) < 4) {
        $errors[] = 'Password minimal 4 karakter.';
    } elseif ($password !== $password2) {
        $errors[] = 'Konfirmasi password tidak cocok.';
    } else {
        // 3. Cek apakah username sudah dipakai.

        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            // Perbaikan: Ubah '$error[]' menjadi '$errors[]'
            $errors[] = 'Username sudah digunakan.';
        } else {
            // 4. Simpan user baru dengan password yang di hash.
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
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            border: 1px solid #e4e4e7;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
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
            padding: 10px 14px;
            font-size: 14px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            margin-bottom: 16px;
            outline: none;
            transition: border-color 0.2s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #111827;
            box-shadow: 0 0 0 2px rgba(17, 24, 39, 0.1);
        }

        button[type="submit"] {
            width: 100%;
            background-color: #111827;
            color: white;
            padding: 10px;
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
    <div>
        <h2>Daftar Akun</h2>

        <?php foreach ($errors as $e): ?>
            <p style="color: red;"><?= htmlspecialchars($e) ?></p>
        <?php endforeach; ?>

        <?php if ($success): ?>
            <p style="color: green;"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <form method="post" action="">
            <label for="">Username</label>
            <input type="text" name="username" required>
            <br>
            <label for="">Password</label>
            <input type="password" name="password" required>
            <br>
            <label for="">Konfirmasi Password</label>
            <input type="password" name="password2" required>
            <br>
            <button type="submit">Daftar</button>
        </form>

        <p>Sudah punya akun? <a href="masuk.php">Login di sini</a></p>
    </div>
</body>
</html>