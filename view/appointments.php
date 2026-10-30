<?php
ob_start();
?>

<div class="appointments-page">
    <h2><?= t('Записаться на приём', 'Broneeri aeg') ?></h2>

    <p><?= t('Выберите услугу, мастера и удобное время.', 'Vali teenus, meister ja sobiv aeg.') ?></p>

    <?php if (!empty($error)): ?>
        <p class="error-message">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success-message">
            <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>

    <form class="appointment-form" method="POST">

        <label for="service_id">
            <?= t('Услуга', 'Teenus') ?>
        </label>

        <select name="service_id" id="service_id" required>
            <option value="">
                <?= t('Выберите услугу', 'Vali teenus') ?>
            </option>

            <?php foreach ($services as $service): ?>
                <option value="<?= (int)$service['id'] ?>">
                    <?= htmlspecialchars(
                        ($_SESSION['lang'] ?? 'ru') === 'et'
                            ? $service['name_et']
                            : $service['name_ru'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="employee_id">
            <?= t('Мастер', 'Meister') ?>
        </label>

        <select name="employee_id" id="employee_id" required>
            <option value="">
                <?= t('Выберите мастера', 'Vali meister') ?>
            </option>

            <?php foreach ($employees as $employee): ?>
                <option value="<?= (int)$employee['id'] ?>">
                    <?= htmlspecialchars(
                        $employee['first_name'] . ' ' . $employee['last_name'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="appointment_date">
            <?= t('Дата', 'Kuupäev') ?>
        </label>

        <input
            type="date"
            name="appointment_date"
            id="appointment_date"
            min="<?= date('Y-m-d') ?>"
            required
        >

        <label for="appointment_time">
            <?= t('Время', 'Kellaaeg') ?>
        </label>

        <input
            type="time"
            name="appointment_time"
            id="appointment_time"
            required
        >

        <label for="comment">
            <?= t('Дополнительная информация', 'Lisainfo') ?>
        </label>

        <textarea
            name="comment"
            id="comment"
            rows="4"
            placeholder="<?= t('Пожелания или дополнительная информация...', 'Soovid või lisainfo...') ?>"
        ></textarea>

        <button type="submit">
            <?= t('Записаться на приём', 'Broneeri aeg') ?>
        </button>

    </form>
</div>

<?php
$content = ob_get_clean();
include 'view/layout.php';
?>