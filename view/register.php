<?php
ob_start();
?>

<div class="auth-page">
    <h2>Registreeru</h2>

    <?php if (!empty($error)): ?>
        <p class="auth-error">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="/ilusalong/register" class="auth-form">
        <label for="first_name">Eesnimi</label>
        <input type="text" name="first_name" id="first_name" required>

        <label for="last_name">Perekonnanimi</label>
        <input type="text" name="last_name" id="last_name" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Parool (vähemalt 8 märki)</label>
        <input type="password" name="password" id="password" minlength="8" required>

        <label for="confirm">Korda parooli</label>
        <input type="password" name="confirm" id="confirm" minlength="8" required>

        <button type="submit">Registreeru</button>
    </form>

    <p>On juba konto?
        <a href="/ilusalong/login">Logi sisse</a>
    </p>
</div>

<?php
$content = ob_get_clean();
include 'view/layout.php';
?>
