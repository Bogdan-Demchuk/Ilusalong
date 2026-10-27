<h2>Teenused</h2>

<?php if (empty($services)): ?>
    <p>Teenuseid ei leitud.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <?php foreach (array_keys($services[0]) as $column): ?>
                    <th><?= htmlspecialchars((string) $column, ENT_QUOTES, 'UTF-8') ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($services as $service): ?>
                <tr>
                    <?php foreach ($service as $value): ?>
                        <td><?= htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>