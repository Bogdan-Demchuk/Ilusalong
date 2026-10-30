<h2>Uue broneeringu lisamine</h2>

<?php if (!empty($error)): ?>
    <p class="error">
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
    </p>
<?php endif; ?>

<form method="POST" action="/ilusalong/ilusalong_admin/appointments/add">

    <label for="user_id">Klient:</label>
    <select name="user_id" id="user_id" required>
        <option value="">Vali klient</option>

        <?php foreach ($users as $user): ?>
            <option
                value="<?= (int) $user['id'] ?>"
                <?= (string) $appointment['user_id'] === (string) $user['id'] ? 'selected' : '' ?>
            >
                <?= htmlspecialchars(
                    $user['first_name'] . ' ' . $user['last_name'] . ' (' . $user['email'] . ')',
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="employee_id">Töötaja:</label>
    <select name="employee_id" id="employee_id" required>
        <option value="">Vali töötaja</option>

        <?php foreach ($employees as $employee): ?>
            <option
                value="<?= (int) $employee['id'] ?>"
                <?= (string) $appointment['employee_id'] === (string) $employee['id'] ? 'selected' : '' ?>
            >
                <?= htmlspecialchars(
                    $employee['first_name'] . ' ' . $employee['last_name'],
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="service_id">Teenus:</label>
    <select name="service_id" id="service_id" required>
        <option value="">Vali teenus</option>

        <?php foreach ($services as $service): ?>
            <option
                value="<?= (int) $service['id'] ?>"
                <?= (string) $appointment['service_id'] === (string) $service['id'] ? 'selected' : '' ?>
            >
                <?= htmlspecialchars(
                    $service['name_et'] . ' / ' . $service['name_ru'] .
                    ' — ' . $service['price'] . ' € (' . $service['duration'] . ' min)',
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="appointment_date">Kuupäev:</label>
    <input
        type="date"
        name="appointment_date"
        id="appointment_date"
        value="<?= htmlspecialchars($appointment['appointment_date'], ENT_QUOTES, 'UTF-8') ?>"
        required
    >

    <label for="appointment_time">Kellaaeg:</label>
    <input
        type="time"
        name="appointment_time"
        id="appointment_time"
        value="<?= htmlspecialchars($appointment['appointment_time'], ENT_QUOTES, 'UTF-8') ?>"
        required
    >

    <label for="status">Staatus:</label>
    <input
        type="text"
        name="status"
        id="status"
        value="<?= htmlspecialchars($appointment['status'], ENT_QUOTES, 'UTF-8') ?>"
        required
    >

    <label for="comment">Kommentaar:</label>
    <textarea
        name="comment"
        id="comment"
    ><?= htmlspecialchars($appointment['comment'], ENT_QUOTES, 'UTF-8') ?></textarea>

    <button type="submit">Salvesta broneering</button>
</form>

<p>
    <a href="/ilusalong/ilusalong_admin/appointments">Tagasi</a>
</p>