<?php
/**
 * Menyimpan pilihan bahasa ke $_SESSION lalu kembali ke halaman asal.
 */
require_once __DIR__ . '/includes/bahasa.php';

$lang = $_GET['lang'] ?? '';
if (in_array($lang, $bahasa_tersedia, true)) {
    $_SESSION['lang'] = $lang;
}

// Whitelist halaman tujuan (mencegah open redirect)
$halaman_boleh = ['index.php', 'tambah.php', 'edit.php', 'login.php'];
$kembali = $_GET['kembali'] ?? 'index.php';
if (!in_array($kembali, $halaman_boleh, true)) {
    $kembali = 'index.php';
}

// edit.php butuh parameter id
$tambahan = '';
if ($kembali === 'edit.php' && isset($_SERVER['HTTP_REFERER'])) {
    parse_str(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY) ?? '', $q);
    if (isset($q['id']) && ctype_digit((string)$q['id'])) {
        $tambahan = '?id=' . (int)$q['id'];
    } else {
        $kembali = 'index.php';
    }
}

header('Location: ' . $kembali . $tambahan);
exit;
