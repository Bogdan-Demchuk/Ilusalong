<h2>Kategooriad</h2>

<?php if (empty($categories)): ?>
    <p>Kategooriaid ei leitud.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <?php foreach (array_keys($categories[0]) as $column): ?>
                    <th><?= htmlspecialchars((string) $column, ENT_QUOTES, 'UTF-8') ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <?php foreach ($category as $value): ?>
                        <td><?= htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>