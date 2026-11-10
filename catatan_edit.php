<?php
// catatan_edit.php - UPDATE catatan.
require_once 'konfigurasi.php';
require_login();

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { redirect('catatan.php'); }

// Ambil catatan, pastikan milik user yang login (keamanan).
$stmt = $pdo->prepare('SELECT id, judul, isi FROM notes WHERE id = ? AND user_id = ?');
$stmt->execute([$id, $_SESSION['user_id']]);
$note = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$note) { redirect('catatan.php'); }

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul'] ?? '');
    $isi = trim($_POST['isi'] ?? '');

    if ($judul === '' || $isi === '') {
        $errors[] = 'Judul dan isi wajib diisi.';
    } else {
        $stmt = $pdo->prepare('UPDATE notes SET judul = ?, isi = ? WHERE id = ? AND user_id = ?');
        $stmt->execute([$judul, $isi, $id, $_SESSION['user_id']]);
        redirect('catatan.php');
    }
} else {
    $judul = $note['judul'];
    $isi = $note['isi'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Catatan</title>
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
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #ffffff;
            padding: 40px;
            width: 100%;
            max-width: 500px;
            border: 1px solid #e4e4e7;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03);
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
            padding: 10px 14px;
            font-size: 14px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            margin-bottom: 16px;
            outline: none;
            transition: border-color 0.2s;
            font-family: inherit;
        }

        input[type="text"]:focus,
        textarea:focus {
            border-color: #111827;
            box-shadow: 0 0 0 2px rgba(17, 24, 39, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 120px;
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
            padding: 10px;
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
            padding: 10px;
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
    </style>
    
</head>

<body>
<div class="container">
    <h2>Edit Catatan</h2>
    <?php foreach ($errors as $e): ?>
        <p style="color:red;"><?= htmlspecialchars($e) ?></p>
    <?php endforeach; ?>
    <form method="post" action="">
        <p>
            <label>Judul<br>
            <input type="text" name="judul" value="<?= htmlspecialchars($judul) ?>" required></label>
        </p>
        <p>
            <label>Isi<br>
            <textarea name="isi" rows="4" cols="40" required><?= htmlspecialchars($isi) ?></textarea></label>
        </p>
        <p>
            <button type="submit">Update</button>
            <a href="catatan.php">Batal</a>
        </p>
    </form>
</div>
</body>
</html>