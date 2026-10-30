<h2>Broneeringud</h2>

<p>
    <a href="/ilusalong/ilusalong_admin/">
        ← Tagasi admini avalehele
    </a>
</p>
<p>
    <a href="/ilusalong/ilusalong_admin/appointments/add">
        + Lisa uus broneering
    </a>
</p>

<?php if (empty($appointments)): ?>
    <p>Broneeringuid ei leitud.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Klient</th>
                <th>Töötaja</th>
                <th>Teenus</th>
                <th>Kuupäev</th>
                <th>Kellaaeg</th>
                <th>Staatus</th>
                <th>Kommentaar</th>
                <th>Tegevused</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($appointments as $item): ?>
                <tr>
                    <td><?= (int) $item['id'] ?></td>

                    <td>
                        <?= htmlspecialchars($item['client_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item['employee_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item['service_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item['appointment_date'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(substr((string) ($item['appointment_time'] ?? ''), 0, 5), ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item['status'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item['comment'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                        <a href="/ilusalong/ilusalong_admin/appointments/edit?id=<?= (int) $item['id'] ?>">
                            Muuda
                        </a>
                        |
                        <a href="/ilusalong/ilusalong_admin/appointments/delete?id=<?= (int) $item['id'] ?>">
                            Kustuta
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>