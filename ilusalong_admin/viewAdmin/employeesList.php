<h2>Töötajad</h2>

<p>
    <a href="/ilusalong/ilusalong_admin/">
        ← Tagasi admini avalehele
    </a>
</p>

<p>
    <a href="/ilusalong/ilusalong_admin/employees/add">
        + Lisa töötaja
    </a>
</p>

<?php if (empty($employees)): ?>
    <p>Töötajaid ei leitud.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Eesnimi</th>
                <th>Perekonnanimi</th>
                <th>Telefon</th>
                <th>E-post</th>
                <th>Amet</th>
                <th>Foto</th>
                <th>Tegevused</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($employees as $employee): ?>
                <tr>
                    <td><?= (int) $employee['id'] ?></td>

                    <td>
                        <?= htmlspecialchars($employee['first_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($employee['last_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($employee['phone'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($employee['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($employee['position'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($employee['photo'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                        <a href="/ilusalong/ilusalong_admin/employees/edit?id=<?= (int) $employee['id'] ?>">
                            Muuda
                        </a>
                        |
                        <a href="/ilusalong/ilusalong_admin/employees/delete?id=<?= (int) $employee['id'] ?>">
                            Kustuta
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>