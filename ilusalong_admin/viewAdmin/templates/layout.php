<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ilusalong Admin</title>

    <link rel="stylesheet"
          href="/ilusalong/ilusalong_admin/public/css/admin.css">
</head>
<body>

<header class="admin-header">
    <h1>Ilusalong Admin</h1>

    <nav>
        <a href="/ilusalong/ilusalong_admin/">Avaleht</a>
        <a href="/ilusalong/ilusalong_admin/appointments">Broneeringud</a>
        <a href="/ilusalong/ilusalong_admin/services">Teenused</a>
        <a href="/ilusalong/ilusalong_admin/categories">Kategooriad</a>
        <a href="/ilusalong/ilusalong_admin/employees">Töötajad</a>
        <a href="/ilusalong/ilusalong_admin/reviews">Arvustused</a>
        <a href="/ilusalong/logout">Logi välja</a>
    </nav>
</header>

<main class="admin-main">
    <?= $content ?>
</main>

</body>
</html>