<h2>Teenuste haldamine</h2>
<p>
    <a href="/ilusalong/ilusalong_admin/">
        ← Tagasi admini avalehele
    </a>
</p>

<p>
    <a href="/ilusalong/ilusalong_admin/services/add">+ Lisa uus teenus</a>
</p>

<?php if (empty($services)): ?>
    <p>Teenuseid ei leitud.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Kategooria</th>
                <th>Nimi (ET)</th>
                <th>Nimi (RU)</th>
                <th>Hind</th>
                <th>Kestus</th>
                <th>Tegevused</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($services as $service): ?>
                <tr>
                    <td><?= (int) $service['id'] ?></td>

                    <td>
                        <?= htmlspecialchars($service['category_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($service['name_et'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($service['name_ru'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                        <?= htmlspecialchars((string) $service['price'], ENT_QUOTES, 'UTF-8') ?> €
                    </td>

                    <td>
                        <?= (int) $service['duration'] ?> min
                    </td>

                    <td>
                        <a href="/ilusalong/ilusalong_admin/services/edit?id=<?= (int) $service['id'] ?>">
                            Muuda
                        </a>
                        |
                        <a href="/ilusalong/ilusalong_admin/services/delete?id=<?= (int) $service['id'] ?>">
                            Kustuta
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>