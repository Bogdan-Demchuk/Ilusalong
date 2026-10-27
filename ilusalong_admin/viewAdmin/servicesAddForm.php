<h2>Uue teenuse lisamine</h2>

<?php if (!empty($error)): ?>
    <p class="error">
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
    </p>
<?php endif; ?>

<form method="POST" action="/ilusalong/ilusalong_admin/services/add">
    <label for="category_id">Kategooria:</label>

    <select id="category_id" name="category_id" required>
        <option value="">Vali kategooria</option>

        <?php foreach ($categories as $category): ?>
            <option
                value="<?= (int) $category['id'] ?>"
                <?= (string) $service['category_id'] === (string) $category['id'] ? 'selected' : '' ?>
            >
                <?= htmlspecialchars(
                    $category['name_et'] . ' / ' . $category['name_ru'],
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="name_et">Nimi eesti keeles:</label>
    <input
        id="name_et"
        type="text"
        name="name_et"
        value="<?= htmlspecialchars($service['name_et'], ENT_QUOTES, 'UTF-8') ?>"
        required
    >

    <label for="name_ru">Название на русском:</label>
    <input
        id="name_ru"
        type="text"
        name="name_ru"
        value="<?= htmlspecialchars($service['name_ru'], ENT_QUOTES, 'UTF-8') ?>"
        required
    >

    <label for="description_et">Kirjeldus eesti keeles:</label>
    <textarea id="description_et" name="description_et"><?= htmlspecialchars($service['description_et'], ENT_QUOTES, 'UTF-8') ?></textarea>

    <label for="description_ru">Описание на русском:</label>
    <textarea id="description_ru" name="description_ru"><?= htmlspecialchars($service['description_ru'], ENT_QUOTES, 'UTF-8') ?></textarea>

    <label for="price">Hind (€):</label>
    <input
        id="price"
        type="number"
        name="price"
        min="0"
        step="0.01"
        value="<?= htmlspecialchars($service['price'], ENT_QUOTES, 'UTF-8') ?>"
        required
    >

    <label for="duration">Kestus (minutites):</label>
    <input
        id="duration"
        type="number"
        name="duration"
        min="1"
        step="1"
        value="<?= htmlspecialchars($service['duration'], ENT_QUOTES, 'UTF-8') ?>"
        required
    >

    <button type="submit">Salvesta</button>
</form>

<p>
    <a href="/ilusalong/ilusalong_admin/services">Tagasi</a>
</p>