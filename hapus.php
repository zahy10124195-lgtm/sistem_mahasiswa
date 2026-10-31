<?php
// DELETE: menghapus data tertentu (hanya via POST + token CSRF)
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

if (!csrf_valid($_POST['csrf'] ?? null)) {
    set_flash('error', 'err_csrf');
    header('Location: index.php');
    exit;
}

$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
if ($id === false || $id === null || $id < 1) {
    set_flash('error', 'not_found');
    header('Location: index.php');
    exit;
}

$stmt = $koneksi->prepare('DELETE FROM mahasiswa WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$terhapus = $stmt->affected_rows;
$stmt->close();

if ($terhapus > 0) {
    set_flash('success', 'success_delete');
} else {
    set_flash('error', 'not_found');
}
header('Location: index.php');
exit;
