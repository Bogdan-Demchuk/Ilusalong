<h2>Broneeringu kustutamine</h2>

<?php if (!empty($error)): ?>
    <p class="error">
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
    </p>
<?php endif; ?>

<p>
    Kas oled kindel, et soovid kustutada broneeringu
    <strong>#<?= (int) $appointment['id'] ?></strong>?
</p>

<p>
    Kuupäev:
    <?= htmlspecialchars($appointment['appointment_date'], ENT_QUOTES, 'UTF-8') ?>
</p>

<p>
    Kellaaeg:
    <?= htmlspecialchars($appointment['appointment_time'], ENT_QUOTES, 'UTF-8') ?>
</p>

<p>
    Staatus:
    <?= htmlspecialchars($appointment['status'], ENT_QUOTES, 'UTF-8') ?>
</p>

<form method="POST" action="/ilusalong/ilusalong_admin/appointments/delete?id=<?= (int) $appointment['id'] ?>">
    <button type="submit">Jah, kustuta</button>

    <a href="/ilusalong/ilusalong_admin/appointments">
        Tühista
    </a>
</form>