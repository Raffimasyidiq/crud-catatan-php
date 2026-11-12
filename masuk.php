<?php
// masuk.php
// Halaman login

require_once 'konfigurasi.php';

// Jika sudah login, langsung ke dashboard.
if (is_logged_in()) {
    redirect('beranda.php');
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $errors[] = 'Username dan password wajib diisi!';
    } else {
        // 1. Cari user berdasarkan username.
        $stmt = $pdo->prepare('SELECT id, username, password FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // 2. Verif password
        if ($user && password_verify($password, $user['password'])) {
             // 3. Simpan Data user ke session
             $_SESSION['user_id'] = $user['id'];
             $_SESSION['username'] = $user['username'];

             redirect('beranda.php');
        } else {
            $errors[] = 'Username atau password salah.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f7f7f8;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh; /* Aman untuk perangkat mobile / layar pendek */
            padding: 20px;     /* Memberikan jarak aman di pinggir layar HP */
        }

        .container {
            background-color: white;
            padding: 32px;
            width: 100%;
            max-width: 420px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }

        h2 {
            font-size: 24px;
            font-weight: 700; /* Diperbaiki dari '700p' */
            color: #111827;
            text-align: center;
            margin-bottom: 24px;
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
        
        .error-msg {
            background-color: #fef2f2;
            color: #991b1b;
            padding: 10px;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 16px;
            border: 1px solid #f87171;
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

        /* Penyesuaian opsional untuk layar HP yang sangat kecil */
        @media (max-width: 480px) {
            .container {
                padding: 20px;
                border: none;
                box-shadow: none;
                background-color: transparent;
            }
            body {
                background-color: #ffffff;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>

        <?php foreach ($errors as $e): ?>
            <div class="error-msg"><?= htmlspecialchars($e) ?></div>
        <?php endforeach; ?>

        <form method="post" action="">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Masuk</button>
        </form>

        <p>Belum punya akun? <a href="daftar.php">Daftar di sini</a></p>
    </div>
</body>
</html>