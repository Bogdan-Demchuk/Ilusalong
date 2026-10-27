<h2>Muuda töötajat</h2>

<?php if (!empty($error)): ?>
    <p class="error">
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
    </p>
<?php endif; ?>

<form method="POST"
      action="/ilusalong/ilusalong_admin/employees/edit?id=<?= (int) $employee['id'] ?>">

    <label for="first_name">Eesnimi</label>
    <input
        type="text"
        id="first_name"
        name="first_name"
        value="<?= htmlspecialchars($employee['first_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
        required
    >

    <label for="last_name">Perekonnanimi</label>
    <input
        type="text"
        id="last_name"
        name="last_name"
        value="<?= htmlspecialchars($employee['last_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
        required
    >

    <label for="phone">Telefon</label>
    <input
        type="text"
        id="phone"
        name="phone"
        value="<?= htmlspecialchars($employee['phone'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
    >

    <label for="email">E-post</label>
    <input
        type="email"
        id="email"
        name="email"
        value="<?= htmlspecialchars($employee['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
        required
    >

    <label for="position">Amet</label>
    <input
        type="text"
        id="position"
        name="position"
        value="<?= htmlspecialchars($employee['position'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
    >

    <label for="photo">Foto (faili tee või URL)</label>
    <input
        type="text"
        id="photo"
        name="photo"
        value="<?= htmlspecialchars($employee['photo'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
    >

    <button type="submit">Salvesta</button>
    <a href="/ilusalong/ilusalong_admin/employees">Tühista</a>
</form>