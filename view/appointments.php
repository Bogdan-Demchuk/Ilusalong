<?php
ob_start();
?>

<div class="appointments-page">
    <h2>Broneeri aeg</h2>
    <p>Vali teenus, meister ja sobiv aeg.</p>

    <form class="appointment-form" method="POST">
        <label for="service_id">Teenus</label>
        <select name="service_id" id="service_id" required>
            <option value="">Vali teenus</option>
            <?php foreach ($services as $service): ?>
                <option value="<?php echo (int)$service['id']; ?>">
                    <?php echo htmlspecialchars($service['name_et']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="employee_id">Meister</label>
        <select name="employee_id" id="employee_id" required>
            <option value="">Vali meister</option>
            <?php foreach ($employees as $employee): ?>
                <option value="<?php echo (int)$employee['id']; ?>">
                    <?php
                    echo htmlspecialchars(
                        $employee['first_name'] . ' ' .
                        $employee['last_name']
                    );
                    ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="appointment_date">Kuupäev</label>
        <input
            type="date"
            name="appointment_date"
            id="appointment_date"
            min="<?php echo date('Y-m-d'); ?>"
            required
        >

        <label for="appointment_time">Kellaaeg</label>
        <input
            type="time"
            name="appointment_time"
            id="appointment_time"
            required
        >

        <label for="comment">Lisainfo</label>
        <textarea
            name="comment"
            id="comment"
            rows="4"
            placeholder="Soovid või lisainfo..."
        ></textarea>

        <button type="submit">Broneeri aeg</button>
    </form>
</div>

<?php
$content = ob_get_clean();
include 'view/layout.php';
?>
