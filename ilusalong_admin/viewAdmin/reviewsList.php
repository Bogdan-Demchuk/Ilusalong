<h2>Arvustused</h2>

<p>
    <a href="/ilusalong/ilusalong_admin/">
        ← Tagasi admini avalehele
    </a>
</p>

<?php if (empty($reviews)): ?>
    <p>Arvustusi ei leitud.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Kasutaja</th>
                <th>Hinnang</th>
                <th>Kommentaar</th>
                <th>Kuupäev</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reviews as $review): ?>
                <tr>
                    <td>
                        <?= htmlspecialchars((string) ($review['id'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                    </td>
                    <td>
                        <?= htmlspecialchars((string) ($review['user_name'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                    </td>
                    <td>
                        <?= htmlspecialchars((string) ($review['rating'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                    </td>
                    <td>
                        <?= htmlspecialchars((string) ($review['comment'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                    </td>
                    <td>
                        <?= htmlspecialchars((string) ($review['created_at'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>