
<?php ob_start(); ?>

<div class="reviews-page">
    <h2>Arvustused</h2>
    <p>Jaga oma kogemust ja tutvu teiste klientide arvamustega.</p>

    <?php if (!empty($error)): ?>
        <p class="error-message">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success-message">
            <?php echo htmlspecialchars($success); ?>
        </p>
    <?php endif; ?>

    <?php if (isset($_SESSION['user_id'])): ?>
        <section class="review-form-section">
            <h3>Lisa arvustus</h3>

            <form class="review-form" method="POST"
                  action="/ilusalong/reviews">

                <label for="service_id">Teenus</label>
                <select name="service_id" id="service_id" required>
                    <option value="">Vali teenus</option>
                    <?php foreach ($services as $service): ?>
                        <option value="<?php echo (int) $service['id']; ?>">
                            <?php echo htmlspecialchars($service['name_et']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="rating">Hinnang</label>
                <select name="rating" id="rating" required>
                    <option value="">Vali hinnang</option>
                    <option value="5">★★★★★ — Väga hea</option>
                    <option value="4">★★★★ — Hea</option>
                    <option value="3">★★★ — Keskmine</option>
                    <option value="2">★★ — Halb</option>
                    <option value="1">★ — Väga halb</option>
                </select>

                <label for="comment">Kommentaar</label>
                <textarea
                    name="comment"
                    id="comment"
                    rows="4"
                    maxlength="2000"
                    required
                    placeholder="Kirjuta oma kogemusest..."
                ></textarea>

                <button type="submit">Lisa arvustus</button>
            </form>
        </section>
    <?php else: ?>
        <p>
            Arvustuse lisamiseks
            <a href="/ilusalong/login">logi sisse</a>.
        </p>
    <?php endif; ?>

    <section class="reviews-list">
        <h3>Klientide arvamused</h3>

        <?php if (empty($reviews)): ?>
            <p>Arvustusi pole veel lisatud.</p>
        <?php else: ?>
            <?php foreach ($reviews as $review): ?>
                <article class="review-card">
                    <h4>
                        <?php echo htmlspecialchars(
                            $review['first_name'] . ' ' .
                            $review['last_name']
                        ); ?>
                    </h4>

                    <p class="review-stars">
                        <span aria-label="<?php echo (int) $review['rating']; ?> / 5">
                            <?php echo str_repeat('★', (int) $review['rating']); ?>
                            <?php echo str_repeat('☆', 5 - (int) $review['rating']); ?>
                        </span>
                    </p>

                    <p>
                        <strong>Teenus:</strong>
                        <?php echo htmlspecialchars($review['name_et']); ?>
                    </p>

                    <p class="review-comment">
                        <?php echo nl2br(htmlspecialchars($review['comment'])); ?>
                    </p>

                    <small>
                        <?php echo htmlspecialchars($review['created_at']); ?>
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
