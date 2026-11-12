<?php
// catatan_tambah.php - CREATE catatan baru.
require_once 'konfigurasi.php';
require_login();

$errors = [];
$judul = '';
$isi = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul'] ?? '');
    $isi = trim($_php_isi ?? $_POST['isi'] ?? ''); // normalisasi aman

    if ($judul === '' || $isi === '') {
        $errors[] = 'Judul dan isi wajib diisi.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO notes (user_id, judul, isi) VALUES (?, ?, ?)');
        $stmt->execute([$_SESSION['user_id'], $judul, $isi]);
        redirect('catatan.php');
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Catatan</title>
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
            max-width: 500px;
            border: 1px solid #e4e4e7;
            border-radius: 10px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }

        h2 {
            font-size: 22px;
            font-weight: 700;
            color: #111827;
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

        label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px 14px;
            font-size: 14px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            margin-bottom: 16px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            font-family: inherit;
        }

        input[type="text"]:focus,
        textarea:focus {
            border-color: #111827;
            box-shadow: 0 0 0 3px rgba(17, 24, 39, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 140px;
            line-height: 1.5;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 4px;
        }

        button[type="submit"] {
            flex: 1;
            background-color: #111827;
            color: white;
            padding: 12px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        button[type="submit"]:hover {
            background-color: #1f2937;
        }

        .btn-cancel {
            flex: 1;
            text-align: center;
            text-decoration: none;
            background-color: #ffffff;
            color: #374151;
            padding: 12px;
            font-size: 14px;
            font-weight: 600;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .btn-cancel:hover {
            background-color: #f3f4f6;
            border-color: #9ca3af;
        }

        @media (max-width: 480px) {
            body {
                padding: 16px 12px;
                align-items: flex-start;
            }

            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Tambah Catatan</h2>
    
    <?php foreach ($errors as $e): ?>
        <div class="error-msg"><?= htmlspecialchars($e) ?></div>
    <?php endforeach; ?>
    
    <form method="post" action="">
        <label for="judul">Judul</label>
        <input type="text" id="judul" name="judul" value="<?= htmlspecialchars($judul) ?>" required>

        <label for="isi">Isi</label>
        <textarea id="isi" name="isi" required><?= htmlspecialchars($isi) ?></textarea>

        <div class="form-actions">
            <button type="submit">Simpan</button>
            <a href="catatan.php" class="btn-cancel">Batal</a>
        </div>
    </form>
</div>
</body>
</html>