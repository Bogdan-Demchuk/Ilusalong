<!DOCTYPE html>
<html lang="<?= ($_SESSION['lang'] ?? 'ru') === 'et' ? 'et' : 'ru' ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ilusalong</title>

    <link rel="stylesheet" href="/ilusalong/public/css/mystyle.css">
</head>

<body>

<?php if (!isset($isLoginPage) || !$isLoginPage): ?>

    <header>
        <h1>Ilusalong</h1>

        <div class="language-switcher">
            <a href="<?= htmlspecialchars(languageUrl('ru'), ENT_QUOTES, 'UTF-8') ?>">
                Русский
            </a>

            |

            <a href="<?= htmlspecialchars(languageUrl('et'), ENT_QUOTES, 'UTF-8') ?>">
                Eesti
            </a>
        </div>

        <nav>
            <a href="/ilusalong/index">
                <?= t('Главная', 'Avaleht') ?>
            </a>

            <a href="/ilusalong/services">
                <?= t('Услуги', 'Teenused') ?>
            </a>

            <a href="/ilusalong/category">
                <?= t('Категории', 'Kategooriad') ?>
            </a>

            <a href="/ilusalong/employees">
                <?= t('Мастера', 'Meistrid') ?>
            </a>

            <a href="/ilusalong/reviews">
                <?= t('Отзывы', 'Arvustused') ?>
            </a>
            <a href="/ilusalong/my-appointments">
                <?= t('Записи', 'Broneeringud') ?>
            </a>
            <a href="/ilusalong/logout">
                <?= t('Выйти', 'Logi välja') ?>
            </a>
        </nav>
    </header>

<?php endif; ?>

<main>
    <?php echo $content; ?>
</main>

<?php if (!isset($isLoginPage) || !$isLoginPage): ?>

    <footer>
        <p>&copy; 2026 Ilusalong</p>
    </footer>

<?php endif; ?>

</body>
</html>