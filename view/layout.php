<!DOCTYPE html>
<html lang="et">
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

        <nav>
            <a href="/ilusalong/index">Avaleht</a>
            <a href="/ilusalong/services">Teenused</a>
            <a href="/ilusalong/category">Kategooriad</a>
            <a href="/ilusalong/employees">Meistrid</a>
            <a href="/ilusalong/reviews">Arvustused</a>
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
