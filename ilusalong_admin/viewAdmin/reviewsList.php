<h2>Arvustused</h2>

<?php if (empty($reviews)): ?>
    <p>Arvustusi ei leitud.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <?php foreach (array_keys($reviews[0]) as $column): ?>
                    <th><?= htmlspecialchars((string) $column, ENT_QUOTES, 'UTF-8') ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reviews as $review): ?>
                <tr>
                    <?php foreach ($review as $value): ?>
                        <td><?= htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>