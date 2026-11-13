<?php

ob_start();
?>

<div class="home-page">

    <section class="home-hero">

        <div class="home-hero-content">

            <span class="home-eyebrow">
                <?= t('САЛОН КРАСОТЫ И УХОДА', 'ILU- JA HOOLDUSSALONG') ?>
            </span>

            <h1>
                <?= t(
                    'Красота начинается <span>с заботы о себе</span>',
                    'Ilu algab <span>enesest hoolimisest</span>'
                ) ?>
            </h1>

            <p class="home-hero-description">
                <?= t(
                    'Добро пожаловать в Ilusalong! Откройте для себя атмосферу уюта, профессионального ухода и внимания к каждой детали.',
                    'Tere tulemast Ilusalongi! Avasta hubane õhkkond, professionaalne hoolitsus ja tähelepanu igale detailile.'
                ) ?>
            </p>

            <div class="home-buttons">

                <a href="/ilusalong/appointments" class="home-button">
                    <?= t('Записаться на процедуру', 'Broneeri aeg') ?>
                </a>

                <a href="/ilusalong/services" class="home-button home-button-secondary">
                    <?= t('Наши услуги', 'Meie teenused') ?>
                </a>

            </div>

        </div>

        <div class="home-hero-visual">
            <div class="home-visual-circle">
                <div class="home-visual-inner">
                    Ilusalong
                </div>
            </div>

            <div class="home-visual-label">
                <?= t('Время для себя', 'Aeg iseendale') ?>
            </div>
        </div>

    </section>


    <section class="home-benefits">

        <article class="home-benefit">
            <div class="home-benefit-icon">✿</div>

            <h3><?= t('Профессионализм', 'Professionaalsus') ?></h3>

            <p>
                <?= t(
                    'Внимательный подход и качественный уход.',
                    'Tähelepanelik lähenemine ja kvaliteetne hoolitsus.'
                ) ?>
            </p>
        </article>

        <article class="home-benefit">
            <div class="home-benefit-icon">♡</div>

            <h3><?= t('Забота о вас', 'Hoolime sinust') ?></h3>

            <p>
                <?= t(
                    'Создаём комфортную атмосферу для каждого клиента.',
                    'Loome mugava õhkkonna igale kliendile.'
                ) ?>
            </p>
        </article>

        <article class="home-benefit">
            <div class="home-benefit-icon">✧</div>

            <h3><?= t('Время для красоты', 'Aeg ilule') ?></h3>

            <p>
                <?= t(
                    'Выберите процедуру и уделите время себе.',
                    'Vali protseduur ja võta aega iseendale.'
                ) ?>
            </p>
        </article>

    </section>


    <section class="home-cta">

        <h2>
            <?= t('Подарите себе немного заботы', 'Kingi endale veidi hoolitsust') ?>
        </h2>

        <p>
            <?= t(
                'Выберите подходящую услугу и запишитесь к нашим специалистам.',
                'Vali sobiv teenus ja broneeri aeg meie spetsialistide juurde.'
            ) ?>
        </p>

        <a href="/ilusalong/services" class="home-button">
            <?= t('Выбрать услугу', 'Vali teenus') ?>
        </a>

    </section>

</div>

<?php

$content = ob_get_clean();

$pageCss = '/ilusalong/public/css/home.css';

include 'view/layout.php';
