<?php
// catatan.php - Daftar catatan (READ) + link ke Create/Update/Delete.
require_once 'konfigurasi.php';
require_login();

$user_id =$_SESSION['user_id'];

// Ambil catatan milik user yang login.
$stmt =$pdo->prepare('SELECT id, judul, isi, created_at FROM notes WHERE user_id = ? ORDER BY id DESC');
$stmt->execute([$user_id]);
$notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catatan Saya</title>
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
            padding: 32px 20px;
            display: flex;
            justify-content: center;
        }

        .main-container {
            width: 100%;
            max-width: 800px;
        }

        /* Header Atas */
        .header-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
            background: #ffffff;
            padding: 20px 24px;
            border: 1px solid #e4e4e7;
            border-radius: 10px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03);
        }

        .header-box h2 {
            font-size: 20px;
            font-weight: 700;
            color: #111827;
        }

        .header-box h2 span {
            font-weight: 400;
            color: #6b7280;
            font-size: 14px;
            display: block;
            margin-top: 4px;
        }

        .nav-links {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .nav-links a {
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            padding: 9px 14px;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            background-color: #ffffff;
            transition: all 0.2s;
            text-align: center;
        }

        .nav-links a:hover {
            background-color: #f3f4f6;
            border-color: #9ca3af;
        }

        .nav-links a.btn-primary {
            background-color: #111827;
            color: #ffffff;
            border-color: #111827;
        }

        .nav-links a.btn-primary:hover {
            background-color: #1f2937;
        }

        /* Daftar Catatan (Card Layout) */
        .notes-grid {
            display: grid;
            gap: 16px;
        }

        .note-card {
            background-color: #ffffff;
            border: 1px solid #e4e4e7;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            transition: box-shadow 0.2s;
            word-wrap: break-word;
        }

        .note-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .note-title {
            font-size: 17px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 6px;
        }

        .note-date {
            font-size: 12px;
            color: #9ca3af;
            margin-bottom: 12px;
        }

        .note-content {
            font-size: 14px;
            color: #4b5563;
            line-height: 1.6;
            margin-bottom: 16px;
        }

        .note-actions {
            display: flex;
            gap: 8px;
        }

        .note-actions a {
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            padding: 7px 14px;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            transition: all 0.2s;
            text-align: center;
        }

        .btn-edit {
            color: #374151;
            background-color: #ffffff;
        }

        .btn-edit:hover {
            background-color: #f3f4f6;
            border-color: #9ca3af;
        }

        .btn-delete {
            color: #dc2626;
            background-color: #fef2f2;
            border-color: #fca5a5;
        }

        .btn-delete:hover {
            background-color: #fee2e2;
        }

        .empty-state {
            background: #ffffff;
            border: 1px solid #e4e4e7;
            border-radius: 10px;
            padding: 40px 20px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }

        /* Penyesuaian Responsif untuk HP */
        @media (max-width: 640px) {
            body {
                padding: 16px 12px;
            }

            .header-box {
                flex-direction: column;
                align-items: flex-start;
                padding: 18px;
            }

            .nav-links {
                width: 100%;
            }

            .nav-links a {
                flex: 1;
            }

            .nav-links a.btn-primary {
                flex-basis: 100%;
            }

            .note-actions a {
                flex: 1;
            }
        }
    </style>
</head>
<body>

<div class="main-container">
    <!-- Header Bagian Atas -->
    <div class="header-box">
        <h2>
            Daftar Catatan
            <span>Masuk sebagai: <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></span>
        </h2>
        <div class="nav-links">
            <a href="catatan_tambah.php" class="btn-primary">+ Tambah Catatan</a>
            <a href="beranda.php">Dashboard</a>
            <a href="keluar.php">Logout</a>
        </div>
    </div>

    <!-- Konten Daftar Catatan -->
    <?php if (empty($notes)): ?>
        <div class="empty-state">
            Belum ada catatan yang tersimpan. Silakan buat catatan baru!
        </div>
    <?php else: ?>
        <div class="notes-grid">
            <?php foreach ($notes as $n): ?>
                <div class="note-card">
                    <div class="note-title"><?= htmlspecialchars($n['judul']) ?></div>
                    <div class="note-date">Dibuat pada: <?= htmlspecialchars($n['created_at']) ?></div>
                    <div class="note-content"><?= nl2br(htmlspecialchars($n['isi'])) ?></div>
                    <div class="note-actions">
                        <a href="catatan_edit.php?id=<?= (int)$n['id'] ?>" class="btn-edit">Edit</a>
                        <a href="catatan_hapus.php?id=<?= (int)$n['id'] ?>" class="btn-delete" onclick="return confirm('Yakin ingin menghapus catatan ini?')">Hapus</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>