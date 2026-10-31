<?php
// UPDATE: mengubah data berdasarkan identitas unik (id)
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/validasi.php';
require_once __DIR__ . '/config/koneksi.php';

$id = filter_var($_GET['id'] ?? $_POST['id'] ?? null, FILTER_VALIDATE_INT);
if ($id === false || $id === null || $id < 1) {
    set_flash('error', 'not_found');
    header('Location: index.php');
    exit;
}

// Ambil data lama
$stmt = $koneksi->prepare('SELECT * FROM mahasiswa WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$data_lama = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$data_lama) {
    set_flash('error', 'not_found');
    header('Location: index.php');
    exit;
}

$nilai = [
    'nim' => $data_lama['nim'], 'nama' => $data_lama['nama'], 'email' => $data_lama['email'],
    'prodi' => $data_lama['prodi'], 'angkatan' => $data_lama['angkatan'],
];
$error = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_valid($_POST['csrf'] ?? null)) {
        $error[] = 'err_csrf';
        $nilai = array_merge($nilai, array_intersect_key($_POST, $nilai));
    } else {
        [$nilai, $error] = validasi_mahasiswa($_POST);

        if (!$error) {
            // NIM tidak boleh dipakai mahasiswa lain
            $cek = $koneksi->prepare('SELECT id FROM mahasiswa WHERE nim = ? AND id <> ?');
            $cek->bind_param('si', $nilai['nim'], $id);
            $cek->execute();
            if ($cek->get_result()->num_rows > 0) {
                $error[] = 'err_nim_dup';
            }
            $cek->close();
        }

        if (!$error) {
            $angkatan = (int)$nilai['angkatan'];
            $stmt = $koneksi->prepare('UPDATE mahasiswa SET nim = ?, nama = ?, email = ?, prodi = ?, angkatan = ? WHERE id = ?');
            $stmt->bind_param('ssssii', $nilai['nim'], $nilai['nama'], $nilai['email'], $nilai['prodi'], $angkatan, $id);
            $stmt->execute();
            $stmt->close();

            set_flash('success', 'success_update');
            header('Location: index.php');
            exit;
        }
    }
}

$aksi = 'edit.php?id=' . $id;
$label_tombol = $teks['update'];

require __DIR__ . '/includes/header.php';
?>
<div class="card card-form">
    <h2><?= t('edit_data') ?></h2>
    <?php foreach ($error as $k): ?>
        <div class="alert alert-error"><?= t($k) ?></div>
    <?php endforeach; ?>
    <?php require __DIR__ . '/includes/form_mahasiswa.php'; ?>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
