<?php
ob_start();
?>

<div class="auth-page">
    <h2>Logi sisse</h2>

    <?php if (!empty($error)): ?>
        <p class="auth-error">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="/ilusalong/login" class="auth-form">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Parool</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Logi sisse</button>
    </form>

    <p>Pole veel kontot?
        <a href="/ilusalong/register">Registreeru</a>
    </p>
</div>

<?php
$content = ob_get_clean();
$isLoginPage = true;

include 'view/layout.php';
?>
