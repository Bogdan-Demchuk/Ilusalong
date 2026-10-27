<h2>Broneeringud</h2>

<?php if (empty($appointments)): ?>
    <p>Broneeringuid ei leitud.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <?php foreach (array_keys($appointments[0]) as $column): ?>
                    <th><?= htmlspecialchars((string) $column, ENT_QUOTES, 'UTF-8') ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($appointments as $appointment): ?>
                <tr>
                    <?php foreach ($appointment as $value): ?>
                        <td><?= htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>