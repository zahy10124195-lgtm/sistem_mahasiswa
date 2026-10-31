<?php
// CREATE: menyimpan data baru dari form ke database
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/validasi.php';
require_once __DIR__ . '/config/koneksi.php';

$nilai = ['nim' => '', 'nama' => '', 'email' => '', 'prodi' => '', 'angkatan' => ''];
$error = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_valid($_POST['csrf'] ?? null)) {
        $error[] = 'err_csrf';
        $nilai = array_merge($nilai, array_intersect_key($_POST, $nilai));
    } else {
        [$nilai, $error] = validasi_mahasiswa($_POST);

        if (!$error) {
            // Cek NIM unik
            $cek = $koneksi->prepare('SELECT id FROM mahasiswa WHERE nim = ?');
            $cek->bind_param('s', $nilai['nim']);
            $cek->execute();
            if ($cek->get_result()->num_rows > 0) {
                $error[] = 'err_nim_dup';
            }
            $cek->close();
        }

        if (!$error) {
            $angkatan = (int)$nilai['angkatan'];
            $stmt = $koneksi->prepare('INSERT INTO mahasiswa (nim, nama, email, prodi, angkatan) VALUES (?, ?, ?, ?, ?)');
            $stmt->bind_param('ssssi', $nilai['nim'], $nilai['nama'], $nilai['email'], $nilai['prodi'], $angkatan);
            $stmt->execute();
            $stmt->close();

            set_flash('success', 'success_add');
            header('Location: index.php');
            exit;
        }
    }
}

$aksi = 'tambah.php';
$label_tombol = $teks['save'];

require __DIR__ . '/includes/header.php';
?>
<div class="card card-form">
    <h2><?= t('add_data') ?></h2>
    <?php foreach ($error as $k): ?>
        <div class="alert alert-error"><?= t($k) ?></div>
    <?php endforeach; ?>
    <?php require __DIR__ . '/includes/form_mahasiswa.php'; ?>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
