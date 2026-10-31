<?php
/**
 * Proteksi halaman: wajib login. Sertakan file ini di setiap halaman CRUD.
 */
require_once __DIR__ . '/bahasa.php';

if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

/** Token CSRF sederhana untuk form POST. */
function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_valid(?string $token): bool
{
    return isset($_SESSION['csrf']) && is_string($token) && hash_equals($_SESSION['csrf'], $token);
}

/** Flash message (pesan sekali tampil). */
function set_flash(string $tipe, string $kunci): void
{
    $_SESSION['flash'] = ['tipe' => $tipe, 'kunci' => $kunci];
}
