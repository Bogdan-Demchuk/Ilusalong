<h2>Kategooriad</h2>

<p>
    <a href="/ilusalong/ilusalong_admin/">
        ← Tagasi admini avalehele
    </a>
</p>

<p>
    <a href="/ilusalong/ilusalong_admin/categories/add">
        + Lisa kategooria
    </a>
</p>

<?php if (empty($categories)): ?>
    <p>Kategooriaid ei leitud.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nimi (ET)</th>
                <th>Nimi (RU)</th>
                <th>Tegevused</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td>
                        <?= (int) $category['id'] ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            (string) ($category['name_et'] ?? ''),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            (string) ($category['name_ru'] ?? ''),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </td>

                    <td>
                        <a href="/ilusalong/ilusalong_admin/categories/edit?id=<?= (int) $category['id'] ?>">
                            Muuda
                        </a>

                        |

                        <a href="/ilusalong/ilusalong_admin/categories/delete?id=<?= (int) $category['id'] ?>">
                            Kustuta
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
