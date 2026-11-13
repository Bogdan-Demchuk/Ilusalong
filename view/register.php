<?php
ob_start();
?>

<div class="auth-page">

    <h2><?= t('Регистрация', 'Registreerimine') ?></h2>

    <div class="language-switcher">
        <a href="<?= htmlspecialchars(languageUrl('ru'), ENT_QUOTES, 'UTF-8') ?>">
            Русский
        </a>
        |
        <a href="<?= htmlspecialchars(languageUrl('et'), ENT_QUOTES, 'UTF-8') ?>">
            Eesti
        </a>
    </div>

    <?php if (!empty($error)): ?>
        <p class="auth-error">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="/ilusalong/register" class="auth-form">

        <label for="first_name">
            <?= t('Имя', 'Eesnimi') ?>
        </label>
        <input type="text" name="first_name" id="first_name" required>

        <label for="last_name">
            <?= t('Фамилия', 'Perekonnanimi') ?>
        </label>
        <input type="text" name="last_name" id="last_name" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>

        <label for="password">
            <?= t('Пароль (не менее 8 символов)', 'Parool (vähemalt 8 märki)') ?>
        </label>
        <input type="password" name="password" id="password" minlength="8" required>

        <label for="confirm">
            <?= t('Повторите пароль', 'Korda parooli') ?>
        </label>
        <input type="password" name="confirm" id="confirm" minlength="8" required>

        <button type="submit">
            <?= t('Зарегистрироваться', 'Registreeru') ?>
        </button>

    </form>

    <p>
        <?= t('Уже есть аккаунт?', 'On juba konto?') ?>
        <a href="/ilusalong/login">
            <?= t('Войти', 'Logi sisse') ?>
        </a>
    </p>

</div>

<?php
$content = ob_get_clean();
$isLoginPage = true;

include 'view/layout.php';
?>
