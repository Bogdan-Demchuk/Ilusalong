<h2>Kustuta kategooria</h2>

<p>
    Kas soovid kindlasti kustutada kategooria
    <strong>
        <?= htmlspecialchars($category['name_et'] ?? '', ENT_QUOTES, 'UTF-8') ?>
    </strong>?
</p>

<form method="POST"
      action="/ilusalong/ilusalong_admin/categories/delete?id=<?= (int) $category['id'] ?>">

    <button type="submit"
            onclick="return confirm('Kas oled kindel, et soovid kustutada?')">
        Kustuta
    </button>

    <a href="/ilusalong/ilusalong_admin/categories">Tühista</a>
</form>