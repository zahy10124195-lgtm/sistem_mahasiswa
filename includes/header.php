<?php
// Wajib di-include SETELAH includes/bahasa.php (atau auth.php)
$halaman_ini = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="<?= e($_SESSION['lang']) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= t('app_title') ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="topbar">
    <div class="brand"><?= t('app_title') ?></div>
    <nav class="nav">
        <span class="lang-switch">
            <?= t('language') ?>:
            <a href="set_bahasa.php?lang=id&amp;kembali=<?= e($halaman_ini) ?>" class="<?= $_SESSION['lang'] === 'id' ? 'aktif' : '' ?>">ID</a> |
            <a href="set_bahasa.php?lang=en&amp;kembali=<?= e($halaman_ini) ?>" class="<?= $_SESSION['lang'] === 'en' ? 'aktif' : '' ?>">EN</a>
        </span>
        <?php if (!empty($_SESSION['user_id'])): ?>
            <span class="user"><?= t('welcome') ?>, <strong><?= e($_SESSION['nama_lengkap']) ?></strong></span>
            <a class="btn btn-small btn-light" href="logout.php"><?= t('logout') ?></a>
        <?php endif; ?>
    </nav>
</header>
<main class="container">
