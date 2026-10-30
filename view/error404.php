<?php
ob_start();
?>

<h1>404</h1>

<h2>
    <?= t('Страница не найдена', 'Lehte ei leitud') ?>
</h2>

<p>
    <?= t('Запрашиваемая страница не существует.', 'Soovitud lehte ei ole olemas.') ?>
</p>

<a href="/ilusalong/index">
    <?= t('Вернуться на главную', 'Tagasi avalehele') ?>
</a>

<?php
$content = ob_get_clean();
include_once 'view/layout.php';
?>
