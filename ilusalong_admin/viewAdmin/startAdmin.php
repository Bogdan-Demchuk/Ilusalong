<?php ob_start(); ?>

<section class="dashboard">
    <h2>Administraatori paneel</h2>

    <p>
        Tere tulemast Ilusalongi halduspaneeli!
        Vali menüüst osa, mida soovid hallata.
    </p>

    <div class="dashboard-grid">
        <a href="/ilusalong_admin/appointments" class="dashboard-card">
            <h3>Broneeringud</h3>
            <p>Vaata ja halda klientide broneeringuid.</p>
        </a>

        <a href="/ilusalong_admin/services" class="dashboard-card">
            <h3>Teenused</h3>
            <p>Lisa, muuda ja kustuta teenuseid.</p>
        </a>

        <a href="/ilusalong_admin/categories" class="dashboard-card">
            <h3>Kategooriad</h3>
            <p>Halda teenuste kategooriaid.</p>
        </a>

        <a href="/ilusalong_admin/employees" class="dashboard-card">
            <h3>Töötajad</h3>
            <p>Halda salongi töötajaid.</p>
        </a>

        <a href="/ilusalong_admin/reviews" class="dashboard-card">
            <h3>Arvustused</h3>
            <p>Vaata klientide arvustusi.</p>
        </a>
    </div>
</section>

<?php
$content = ob_get_clean();
include __DIR__ . '/templates/layout.php';
?>