<?php
// READ: menampilkan seluruh data mahasiswa dalam tabel HTML
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/koneksi.php';

$cari = trim($_GET['cari'] ?? '');

if ($cari !== '') {
    $like = '%' . $cari . '%';
    $stmt = $koneksi->prepare('SELECT * FROM mahasiswa WHERE nama LIKE ? OR nim LIKE ? ORDER BY id DESC');
    $stmt->bind_param('ss', $like, $like);
    $stmt->execute();
    $hasil = $stmt->get_result();
} else {
    $hasil = $koneksi->query('SELECT * FROM mahasiswa ORDER BY id DESC');
}
$jumlah = $hasil->num_rows;

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

require __DIR__ . '/includes/header.php';
?>
<div class="card">
    <div class="card-head">
        <h2><?= t('data_title') ?> <small>(<?= t('total') ?>: <?= $jumlah ?>)</small></h2>
        <a href="tambah.php" class="btn btn-primary">+ <?= t('add_data') ?></a>
    </div>

    <?php if ($flash): ?>
        <div class="alert alert-<?= e($flash['tipe']) ?>"><?= t($flash['kunci']) ?></div>
    <?php endif; ?>

    <form method="GET" action="index.php" class="search">
        <input type="text" name="cari" value="<?= e($cari) ?>" placeholder="<?= t('search') ?>">
        <button type="submit" class="btn btn-light"><?= t('search_btn') ?></button>
    </form>

    <div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th><?= t('no') ?></th>
                <th><?= t('nim') ?></th>
                <th><?= t('name') ?></th>
                <th><?= t('email') ?></th>
                <th><?= t('major') ?></th>
                <th><?= t('year') ?></th>
                <th><?= t('action') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php if ($jumlah === 0): ?>
            <tr><td colspan="7" class="center"><?= t('no_data') ?></td></tr>
        <?php else: $no = 1; while ($row = $hasil->fetch_assoc()): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= e($row['nim']) ?></td>
                <td><?= e($row['nama']) ?></td>
                <td><?= e($row['email']) ?></td>
                <td><?= e($row['prodi']) ?></td>
                <td><?= e($row['angkatan']) ?></td>
                <td class="aksi">
                    <a href="edit.php?id=<?= (int)$row['id'] ?>" class="btn btn-small btn-warning"><?= t('edit') ?></a>
                    <form method="POST" action="hapus.php" class="inline"
                          onsubmit="return confirm('<?= e($teks['confirm_delete']) ?>');">
                        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                        <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                        <button type="submit" class="btn btn-small btn-danger"><?= t('delete') ?></button>
                    </form>
                </td>
            </tr>
        <?php endwhile; endif; ?>
        </tbody>
    </table>
    </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
