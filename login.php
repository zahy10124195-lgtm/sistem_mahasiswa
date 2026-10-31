<?php
require_once __DIR__ . '/includes/bahasa.php';
require_once __DIR__ . '/config/koneksi.php';

// Jika sudah login, langsung ke dashboard
if (!empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$pesan_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $pesan_error = 'login_empty';
    } else {
        $stmt = $koneksi->prepare('SELECT id, username, password, nama_lengkap FROM users WHERE username = ? LIMIT 1');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);           // cegah session fixation
            $_SESSION['user_id']      = (int)$user['id'];
            $_SESSION['username']     = $user['username'];
            $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
            header('Location: index.php');
            exit;
        }
        $pesan_error = 'login_failed';
    }
}

require __DIR__ . '/includes/header.php';
?>
<div class="card card-login">
    <h2><?= t('login_title') ?></h2>

    <?php if ($pesan_error): ?>
        <div class="alert alert-error"><?= t($pesan_error) ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php" autocomplete="off">
        <label for="username"><?= t('username') ?></label>
        <input type="text" id="username" name="username" value="<?= e($_POST['username'] ?? '') ?>" required autofocus>

        <label for="password"><?= t('password') ?></label>
        <input type="password" id="password" name="password" required>

        <button type="submit" class="btn btn-primary btn-block"><?= t('login') ?></button>
    </form>
    <p class="hint">Demo: <code>admin</code> / <code>admin123</code></p>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
