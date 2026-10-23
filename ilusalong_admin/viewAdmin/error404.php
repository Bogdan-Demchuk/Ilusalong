<?php ob_start(); ?>

<h2>404 — Lehte ei leitud</h2>
<p>Soovitud administratiivset lehte ei leitud.</p>
<a href="/ilusalong_admin/">Tagasi avalehele</a>

<?php
$content = ob_get_clean();
include __DIR__ . '/templates/layout.php';
?>