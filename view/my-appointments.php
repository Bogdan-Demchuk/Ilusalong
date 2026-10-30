<?php ob_start(); ?>

<div class="appointments-page">

    <h2><?= t('Мои записи', 'Minu broneeringud') ?></h2>

    <p>
        <?= t(
            'Здесь ты можешь посмотреть свои записи.',
            'Siin näed oma broneeritud aegu.'
        ) ?>
    </p>

    <?php if (empty($appointments)): ?>

        <p>
            <?= t(
                'У тебя пока нет записей.',
                'Sul pole veel ühtegi broneeringut.'
            ) ?>
        </p>

        <a href="/ilusalong/appointments">
            <?= t('Записаться на приём', 'Broneeri aeg') ?>
        </a>

    <?php else: ?>

        <?php foreach ($appointments as $appointment): ?>

            <article class="appointment-card">

                <h3>
                    <?php
                    $serviceName = ($_SESSION['lang'] ?? 'ru') === 'et'
                        ? ($appointment['name_et'] ?? '')
                        : ($appointment['name_ru'] ?? $appointment['name_et'] ?? '');

                    echo htmlspecialchars($serviceName, ENT_QUOTES, 'UTF-8');
                    ?>
                </h3>

                <p>
                    <strong><?= t('Мастер', 'Meister') ?>:</strong>

                    <?= htmlspecialchars(
                        $appointment['first_name'] . ' ' . $appointment['last_name'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </p>

                <p>
                    <strong><?= t('Дата', 'Kuupäev') ?>:</strong>

                    <?= htmlspecialchars($appointment['appointment_date'], ENT_QUOTES, 'UTF-8') ?>
                </p>

                <p>
                    <strong><?= t('Время', 'Kellaaeg') ?>:</strong>

                    <?= htmlspecialchars(substr($appointment['appointment_time'], 0, 5), ENT_QUOTES, 'UTF-8') ?>
                </p>

                <p>
                    <strong><?= t('Статус', 'Staatus') ?>:</strong>

                    <?php
                    $statuses = [
                        'pending' => t('Ожидает подтверждения', 'Ootel'),
                        'confirmed' => t('Подтверждена', 'Kinnitatud'),
                        'completed' => t('Завершена', 'Lõpetatud'),
                        'cancelled' => t('Отменена', 'Tühistatud')
                    ];

                    echo htmlspecialchars(
                        $statuses[$appointment['status']] ?? $appointment['status'],
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>
                </p>

                <?php if (
                    in_array(
                        $appointment['status'],
                        ['pending', 'confirmed'],
                        true
                    )
                ): ?>

                    <form
                        method="POST"
                        action="/ilusalong/cancel-appointment"
                        onsubmit="return confirm('<?= t(
                            'Вы действительно хотите отменить запись?',
                            'Kas soovid broneeringu tühistada?'
                        ) ?>');"
                    >

                        <input
                            type="hidden"
                            name="appointment_id"
                            value="<?= (int)$appointment['id'] ?>"
                        >

                        <button type="submit">
                            <?= t('Отменить запись', 'Tühista broneering') ?>
                        </button>

                    </form>

                <?php endif; ?>

            </article>

        <?php endforeach; ?>

    <?php endif; ?>

</div>

<?php
$content = ob_get_clean();
include 'view/layout.php';
?>
