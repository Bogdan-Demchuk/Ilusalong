<h1>Ilusalong Admin</h1>

<p>Tere tulemast administraatori paneeli!</p>

<div class="admin-cards">
    <div class="admin-card">
        <h3>Teenused</h3>
        <p><?= (int) $stats['services'] ?></p>
        <a href="/ilusalong/ilusalong_admin/services">Vaata teenuseid</a>
    </div>

    <div class="admin-card">
        <h3>Kategooriad</h3>
        <p><?= (int) $stats['categories'] ?></p>
        <a href="/ilusalong/ilusalong_admin/categories">Vaata kategooriaid</a>
    </div>

    <div class="admin-card">
        <h3>Meistrid</h3>
        <p><?= (int) $stats['employees'] ?></p>
        <a href="/ilusalong/ilusalong_admin/employees">Vaata meistreid</a>
    </div>

    <div class="admin-card">
        <h3>Broneeringud</h3>
        <p><?= (int) $stats['appointments'] ?></p>
        <a href="/ilusalong/ilusalong_admin/appointments">Vaata broneeringuid</a>
    </div>

    <div class="admin-card">
        <h3>Arvustused</h3>
        <p><?= (int) $stats['reviews'] ?></p>
        <a href="/ilusalong/ilusalong_admin/reviews">Vaata arvustusi</a>
    </div>
</div>