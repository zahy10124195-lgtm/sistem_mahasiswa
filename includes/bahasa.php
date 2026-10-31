<?php
/**
 * Dual bahasa (ID / EN). Pilihan bahasa disimpan di $_SESSION['lang']
 * sehingga konsisten ketika pengguna berpindah halaman.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$bahasa_tersedia = ['id', 'en'];

if (!isset($_SESSION['lang']) || !in_array($_SESSION['lang'], $bahasa_tersedia, true)) {
    $_SESSION['lang'] = 'id'; // bahasa default
}

$teks = require __DIR__ . '/../lang/' . $_SESSION['lang'] . '.php';

/** Ambil teks terjemahan (sudah di-escape untuk HTML). */
function t(string $kunci): string
{
    global $teks;
    return htmlspecialchars($teks[$kunci] ?? $kunci, ENT_QUOTES, 'UTF-8');
}

/** Escape output HTML. */
function e($nilai): string
{
    return htmlspecialchars((string)$nilai, ENT_QUOTES, 'UTF-8');
}
