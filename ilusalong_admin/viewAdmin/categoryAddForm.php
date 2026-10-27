<h2>Lisa kategooria</h2>

<form method="POST" action="/ilusalong/ilusalong_admin/categories/add">
    <label for="name_et">Kategooria nimi (eesti keeles)</label>
    <input
        type="text"
        id="name_et"
        name="name_et"
        required
    >

    <label for="name_ru">Название категории (на русском)</label>
    <input
        type="text"
        id="name_ru"
        name="name_ru"
        required
    >

    <button type="submit">Lisa</button>
    <a href="/ilusalong/ilusalong_admin/categories">Tagasi</a>
</form>