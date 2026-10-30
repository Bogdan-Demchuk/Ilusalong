<?php
ob_start();
?>

<div class="auth-page">
    <h2><?= t('Войти', 'Logi sisse') ?></h2>
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

    <form method="POST" action="/ilusalong/login" class="auth-form">
        <label for="email">
            <?= t('Электронная почта', 'E-post') ?>
        </label>
        <input type="email" name="email" id="email" required>

        <label for="password">
            <?= t('Пароль', 'Parool') ?>
        </label>
        <input type="password" name="password" id="password" required>

        <button type="submit">
            <?= t('Войти', 'Logi sisse') ?>
        </button>
    </form>

    <p>
        <?= t('Ещё нет аккаунта?', 'Pole veel kontot?') ?>
        <a href="/ilusalong/register">
            <?= t('Зарегистрироваться', 'Registreeru') ?>
        </a>
    </p>
</div>

<?php
$content = ob_get_clean();
$isLoginPage = true;

include 'view/layout.php';
?>
