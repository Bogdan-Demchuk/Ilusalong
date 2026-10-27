<?php ob_start(); ?>

<h1>404 — Lehte ei leitud</h1>
<p>Otsitud lehte ei leitud.</p>
<a href="/ilusalong/ilusalong_admin/">Tagasi avalehele</a>

<?php
$content = ob_get_clean();
include __DIR__ . '/templates/layout.php';
?>