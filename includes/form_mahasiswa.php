<?php
/**
 * Form bersama untuk Create & Update.
 * Variabel yang dibutuhkan: $nilai (array), $error (array), $aksi, $label_tombol, $id (opsional)
 */
?>
<form method="POST" action="<?= e($aksi) ?>" novalidate>
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
    <?php if (!empty($id)): ?><input type="hidden" name="id" value="<?= (int)$id ?>"><?php endif; ?>

    <label for="nim"><?= t('nim') ?></label>
    <input type="text" id="nim" name="nim" maxlength="12" inputmode="numeric" value="<?= e($nilai['nim']) ?>" required>

    <label for="nama"><?= t('name') ?></label>
    <input type="text" id="nama" name="nama" maxlength="100" value="<?= e($nilai['nama']) ?>" required>

    <label for="email"><?= t('email') ?></label>
    <input type="email" id="email" name="email" maxlength="100" value="<?= e($nilai['email']) ?>" required>

    <label for="prodi"><?= t('major') ?></label>
    <select id="prodi" name="prodi" required>
        <option value=""><?= t('choose_major') ?></option>
        <?php foreach (DAFTAR_PRODI as $p): ?>
            <option value="<?= e($p) ?>" <?= $nilai['prodi'] === $p ? 'selected' : '' ?>><?= e($p) ?></option>
        <?php endforeach; ?>
    </select>

    <label for="angkatan"><?= t('year') ?></label>
    <input type="number" id="angkatan" name="angkatan" min="2000" max="<?= date('Y') ?>" value="<?= e($nilai['angkatan']) ?>" required>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= e($label_tombol) ?></button>
        <a href="index.php" class="btn btn-light"><?= t('cancel') ?></a>
    </div>
</form>
