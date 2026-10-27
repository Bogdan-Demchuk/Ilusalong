<h2>Teenuse kustutamine</h2>

<?php if (!empty($error)): ?>
    <p class="error">
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
    </p>
<?php endif; ?>

<p>
    Kas oled kindel, et soovid kustutada teenuse
    <strong><?= htmlspecialchars($service['name_et'] ?? '', ENT_QUOTES, 'UTF-8') ?></strong>
    /
    <strong><?= htmlspecialchars($service['name_ru'] ?? '', ENT_QUOTES, 'UTF-8') ?></strong>?
</p>

<p>
    Hind:
    <?= htmlspecialchars((string) ($service['price'] ?? ''), ENT_QUOTES, 'UTF-8') ?> €
</p>

<p>
    Kestus:
    <?= (int) ($service['duration'] ?? 0) ?> min
</p>

<form method="POST" action="/ilusalong/ilusalong_admin/services/delete?id=<?= (int) $service['id'] ?>">
    <button type="submit">Jah, kustuta</button>
    <a href="/ilusalong/ilusalong_admin/services">Tühista</a>
</form>