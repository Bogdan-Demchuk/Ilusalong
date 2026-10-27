<h2>Kustuta töötaja</h2>

<?php if (!empty($error)): ?>
    <p class="error">
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
    </p>
<?php endif; ?>

<p>
    Kas soovid kindlasti kustutada töötaja
    <strong>
        <?= htmlspecialchars(
            ($employee['first_name'] ?? '') . ' ' . ($employee['last_name'] ?? ''),
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </strong>?
</p>

<form method="POST"
      action="/ilusalong/ilusalong_admin/employees/delete?id=<?= (int) $employee['id'] ?>">

    <button type="submit"
            onclick="return confirm('Kas oled kindel, et soovid töötaja kustutada?')">
        Kustuta
    </button>

    <a href="/ilusalong/ilusalong_admin/employees">Tühista</a>
</form>