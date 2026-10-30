<!DOCTYPE html>
<html lang="<?= ($_SESSION['lang'] ?? 'ru') === 'et' ? 'et' : 'ru' ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ilusalong — <?= t('Салон красоты', 'Ilusalong') ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/ilusalong/public/css/mystyle.css">
</head>

<body>

<?php if (!isset($isLoginPage) || !$isLoginPage): ?>

<header class="site-header">

    <div class="header-container">

        <a href="/ilusalong/index" class="logo">
            <span class="logo-icon">✿</span>
            <span>Ilusalong</span>
            <small>BEAUTY & CARE</small>
        </a>

        <div class="header-right">

            <div class="language-switcher">
                <a class="<?= ($_SESSION['lang'] ?? 'ru') === 'ru' ? 'active' : '' ?>"
                   href="<?= htmlspecialchars(languageUrl('ru'), ENT_QUOTES, 'UTF-8') ?>">
                    RU
                </a>

                <span>|</span>

                <a class="<?= ($_SESSION['lang'] ?? 'ru') === 'et' ? 'active' : '' ?>"
                   href="<?= htmlspecialchars(languageUrl('et'), ENT_QUOTES, 'UTF-8') ?>">
                    ET
                </a>
            </div>

            <nav class="main-nav">

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

                <a href="/ilusalong/logout" class="nav-login">
                    <?= t('Выйти', 'Logi välja') ?>
                </a>

            </nav>

        </div>

    </div>

</header>

<?php endif; ?>

<main class="main-content">
    <?php echo $content; ?>
</main>

<?php if (!isset($isLoginPage) || !$isLoginPage): ?>

<footer class="site-footer">

    <div class="footer-content">

        <div class="footer-logo">
            <span>✿ Ilusalong</span>
            <p><?= t('Красота начинается с заботы о себе.', 'Ilu algab enese eest hoolitsemisest.') ?></p>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> Ilusalong. <?= t('Все права защищены.', 'Kõik õigused kaitstud.') ?></p>
        </div>

    </div>

</footer>

<?php endif; ?>

</body>
</html>
