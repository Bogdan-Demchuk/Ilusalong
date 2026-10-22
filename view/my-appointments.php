
<?php ob_start(); ?>

<div class="appointments-page">
    <h2>Minu broneeringud</h2>
    <p>Siin näed oma broneeritud aegu.</p>

    <?php if (empty($appointments)): ?>
        <p>Sul pole veel ühtegi broneeringut.</p>
        <a href="/ilusalong/appointments">Broneeri aeg</a>
    <?php else: ?>
        <?php foreach ($appointments as $appointment): ?>
            <article class="appointment-card">
                <h3>
                    <?php echo htmlspecialchars($appointment['name_et']); ?>
                </h3>

                <p>
                    <strong>Meister:</strong>
                    <?php echo htmlspecialchars(
                        $appointment['first_name'] . ' ' .
                        $appointment['last_name']
                    ); ?>
                </p>

                <p>
                    <strong>Kuupäev:</strong>
                    <?php echo htmlspecialchars($appointment['appointment_date']); ?>
                </p>

                <p>
                    <strong>Kellaaeg:</strong>
                    <?php echo htmlspecialchars(substr($appointment['appointment_time'], 0, 5)); ?>
                </p>

                <p>
                    <strong>Staatus:</strong>
                    <?php
                    $statuses = [
                        'pending' => 'Ootel',
                        'confirmed' => 'Kinnitatud',
                        'completed' => 'Lõpetatud',
                        'cancelled' => 'Tühistatud'
                    ];

                    echo htmlspecialchars(
                        $statuses[$appointment['status']] ?? $appointment['status']
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
                        onsubmit="return confirm('Kas soovid broneeringu tühistada?');"
                    >
                        <input
                            type="hidden"
                            name="appointment_id"
                            value="<?php echo (int) $appointment['id']; ?>"
                        >
                        <button type="submit">Tühista broneering</button>
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
