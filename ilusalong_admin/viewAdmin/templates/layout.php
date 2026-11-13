<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ilusalong — Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/ilusalong/ilusalong_admin/public/css/admin.css">
</head>
<body>

<div class="admin-layout">

    <aside class="admin-sidebar">

        <a href="/ilusalong/ilusalong_admin/" class="admin-brand">
            <span class="admin-brand-icon">✿</span>
            <span class="admin-brand-name">Ilusalong</span>
            <small>ADMINISTRATION</small>
        </a>

        <div class="sidebar-caption">MAIN MENU</div>

        <nav class="admin-nav">
            <a href="/ilusalong/ilusalong_admin/">
                <span class="nav-icon">⌂</span>
                <span>Avaleht</span>
            </a>

            <a href="/ilusalong/ilusalong_admin/appointments">
                <span class="nav-icon">▣</span>
                <span>Broneeringud</span>
            </a>

            <a href="/ilusalong/ilusalong_admin/services">
                <span class="nav-icon">✧</span>
                <span>Teenused</span>
            </a>

            <a href="/ilusalong/ilusalong_admin/categories">
                <span class="nav-icon">▤</span>
                <span>Kategooriad</span>
            </a>

            <a href="/ilusalong/ilusalong_admin/employees">
                <span class="nav-icon">♙</span>
                <span>Töötajad</span>
            </a>

            <a href="/ilusalong/ilusalong_admin/reviews">
                <span class="nav-icon">☆</span>
                <span>Arvustused</span>
            </a>
        </nav>

        <div class="sidebar-bottom">
            <div class="sidebar-caption">ACCOUNT</div>

            <a href="/ilusalong/logout" class="logout-link">
                <span class="nav-icon">↪</span>
                <span>Logi välja</span>
            </a>
        </div>

        <div class="sidebar-footer">
            <span>✿ Ilusalong</span>
            <small>Beauty & Care</small>
        </div>

    </aside>

    <div class="admin-content">

        <header class="admin-topbar">
            <div>
                <span class="topbar-label">ILUSALONG / MANAGEMENT</span>
                <h1>Administraatori paneel</h1>
            </div>

            <a href="/ilusalong/" class="view-site-link">
                Vaata veebilehte ↗
            </a>
        </header>

        <main class="admin-main">
            <?= $content ?>
        </main>

        <footer class="admin-footer">
            © <?= date('Y') ?> Ilusalong — Beauty & Care
        </footer>

    </div>

</div>

</body>
</html>
