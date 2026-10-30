<?php

$content = '
<section class="hero">

    <h2>' . t('Добро пожаловать в Ilusalong!', 'Tere tulemast Ilusalongi!') . '</h2>

    <p>
        ' . t('Профессиональный уход за вашей красотой.', 'Professionaalne hoolitsus sinu ilu eest.') . '
    </p>

    <p>
        ' . t(
            'Ознакомьтесь с нашими услугами и выберите подходящую процедуру.',
            'Tutvu meie teenustega ja vali endale sobiv protseduur.'
        ) . '
    </p>

    <a href="/ilusalong/services" class="button">
        ' . t('Посмотреть услуги', 'Vaata teenuseid') . '
    </a>

</section>
';

include 'view/layout.php';