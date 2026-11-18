<?php
if (isset($_SESSION['user_id']) && ($_SESSION['user_role'] ?? '') === 'user') {
    if (empty($_SESSION['delete_account_token'])) {
        $_SESSION['delete_account_token'] = bin2hex(random_bytes(32));
    }
}
?>
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
    <?php if (!empty($pageCss)): ?>
        <link rel="stylesheet" href="<?= htmlspecialchars($pageCss, ENT_QUOTES, 'UTF-8') ?>">
    <?php endif; ?>
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

                <?php if (isset($_SESSION['user_id'])): ?>
                    <button type="button"
                            class="nav-login"
                            onclick="document.getElementById('accountModal').style.display='flex';"
                            style="cursor:pointer; position:relative; z-index:10001; pointer-events:auto;">
                        <?= t('Выйти', 'Logi välja') ?>
                    </button>
                <?php else: ?>
                    <a href="/ilusalong/login" class="nav-login">
                        <?= t('Войти', 'Logi sisse') ?>
                    </a>
                <?php endif; ?>

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
<?php if (isset($_SESSION['user_id'])): ?>

<div id="accountModal" style="
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.5);
    z-index:9999;
    justify-content:center;
    align-items:center;
    padding:20px;
">
    <div style="
        background:#fffaf6;
        padding:30px;
        border-radius:16px;
        width:100%;
        max-width:380px;
        text-align:center;
        box-shadow:0 10px 40px rgba(0,0,0,0.15);
    ">

        <h2 style="margin-top:0;">
            <?= t('Что вы хотите сделать?', 'Mida soovite teha?') ?>
        </h2>

        <a href="/ilusalong/logout"
           style="
               display:block;
               padding:13px;
               margin:15px 0;
               background:#b78b72;
               color:white;
               text-decoration:none;
               border-radius:8px;
           ">
            <?= t('Выйти из аккаунта', 'Logi kontolt välja') ?>
        </a>

        <?php if (($_SESSION['user_role'] ?? '') === 'user'): ?>

            <form method="POST" action="/ilusalong/delete-account"
                  onsubmit="return confirm('<?= t('Вы действительно хотите удалить аккаунт? Это действие нельзя отменить.', 'Kas soovite kindlasti konto kustutada? Seda toimingut ei saa tagasi võtta.') ?>')">

                <input type="hidden"
                       name="delete_account_token"
                       value="<?= htmlspecialchars($_SESSION['delete_account_token'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

                <button type="submit"
                        style="
                            width:100%;
                            padding:13px;
                            background:#fff;
                            color:#b34b4b;
                            border:1px solid #b34b4b;
                            border-radius:8px;
                            cursor:pointer;
                        ">
                    <?= t('Удалить аккаунт', 'Kustuta konto') ?>
                </button>

            </form>

        <?php endif; ?>

        <button type="button"
                onclick="document.getElementById('accountModal').style.display='none'"
                style="
                    margin-top:15px;
                    border:none;
                    background:none;
                    cursor:pointer;
                    color:#777;
                ">
            <?= t('Отмена', 'Tühista') ?>
        </button>

    </div>
</div>

<?php endif; ?>
</body>
</html>
