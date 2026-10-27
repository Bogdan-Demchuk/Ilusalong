<h2>Muuda kategooriat</h2>

<form method="POST"
      action="/ilusalong/ilusalong_admin/categories/edit?id=<?= (int) $category['id'] ?>">

    <label for="name_et">Kategooria nimi (eesti keeles)</label>
    <input
        type="text"
        id="name_et"
        name="name_et"
        value="<?= htmlspecialchars($category['name_et'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
        required
    >

    <label for="name_ru">Название категории (на русском)</label>
    <input
        type="text"
        id="name_ru"
        name="name_ru"
        value="<?= htmlspecialchars($category['name_ru'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
        required
    >

    <button type="submit">Salvesta</button>
    <a href="/ilusalong/ilusalong_admin/categories">Tühista</a>
</form>