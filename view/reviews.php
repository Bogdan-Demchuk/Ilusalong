<?php
ob_start();
?>

<div class="reviews-page">

    <h2><?= t('Отзывы', 'Arvustused') ?></h2>

    <p>
        <?= t(
            'Поделитесь своим опытом и прочитайте мнения других клиентов.',
            'Jaga oma kogemust ja tutvu teiste klientide arvamustega.'
        ) ?>
    </p>

    <?php if (!empty($error)): ?>
        <p class="error-message">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success-message">
            <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>

    <?php if (isset($_SESSION['user_id'])): ?>

        <section class="review-form-section">

            <h3><?= t('Добавить отзыв', 'Lisa arvustus') ?></h3>

            <form class="review-form" method="POST" action="/ilusalong/reviews">

                <label for="service_id"><?= t('Услуга', 'Teenus') ?></label>

                <select name="service_id" id="service_id" required>
                    <option value="">
                        <?= t('Выберите услугу', 'Vali teenus') ?>
                    </option>

                    <?php foreach ($services as $service): ?>
                        <option value="<?= (int)$service['id'] ?>">
                            <?= htmlspecialchars(
                                ($_SESSION['lang'] ?? 'ru') === 'et'
                                    ? ($service['name_et'] ?? '')
                                    : ($service['name_ru'] ?? $service['name_et'] ?? ''),
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="rating"><?= t('Оценка', 'Hinnang') ?></label>

                <select name="rating" id="rating" required>
                    <option value=""><?= t('Выберите оценку', 'Vali hinnang') ?></option>
                    <option value="5">★★★★★ — <?= t('Отлично', 'Väga hea') ?></option>
                    <option value="4">★★★★ — <?= t('Хорошо', 'Hea') ?></option>
                    <option value="3">★★★ — <?= t('Средне', 'Keskmine') ?></option>
                    <option value="2">★★ — <?= t('Плохо', 'Halb') ?></option>
                    <option value="1">★ — <?= t('Очень плохо', 'Väga halb') ?></option>
                </select>

                <label for="comment"><?= t('Комментарий', 'Kommentaar') ?></label>

                <textarea
                    name="comment"
                    id="comment"
                    rows="4"
                    maxlength="2000"
                    required
                    placeholder="<?= t('Расскажите о своём опыте...', 'Kirjuta oma kogemusest...') ?>"
                ></textarea>

                <button type="submit">
                    <?= t('Добавить отзыв', 'Lisa arvustus') ?>
                </button>

            </form>
        </section>

    <?php else: ?>

        <p>
            <?= t('Чтобы оставить отзыв,', 'Arvustuse lisamiseks') ?>
            <a href="/ilusalong/login">
                <?= t('войдите в аккаунт', 'logi sisse') ?>
            </a>.
        </p>

    <?php endif; ?>

    <section class="reviews-list">

        <h3><?= t('Отзывы клиентов', 'Klientide arvamused') ?></h3>

        <?php if (empty($reviews)): ?>

            <p>
                <?= t('Отзывов пока нет.', 'Arvustusi pole veel lisatud.') ?>
            </p>

        <?php else: ?>

            <?php foreach ($reviews as $review): ?>

                <article class="review-card">

                    <h4>
                        <?= htmlspecialchars(
                            $review['first_name'] . ' ' . $review['last_name'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </h4>

                    <p class="review-stars">
                        <span aria-label="<?= (int)$review['rating'] ?> / 5">
                            <?= str_repeat('★', (int)$review['rating']) ?>
                            <?= str_repeat('☆', 5 - (int)$review['rating']) ?>
                        </span>
                    </p>

                    <p>
                        <strong><?= t('Услуга', 'Teenus') ?>:</strong>

                        <?= htmlspecialchars(
                            ($_SESSION['lang'] ?? 'ru') === 'et'
                                ? ($review['name_et'] ?? '')
                                : ($review['name_ru'] ?? $review['name_et'] ?? ''),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </p>

                    <p class="review-comment">
                        <?= nl2br(htmlspecialchars($review['comment'], ENT_QUOTES, 'UTF-8')) ?>
                    </p>

                    <small>
                        <?= htmlspecialchars($review['created_at'], ENT_QUOTES, 'UTF-8') ?>
                    </small>

                </article>

            <?php endforeach; ?>

        <?php endif; ?>

    </section>

</div>

<?php
$content = ob_get_clean();
include 'view/layout.php';
?>