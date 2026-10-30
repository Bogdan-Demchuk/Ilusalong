<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="<?= ($_SESSION['lang'] ?? 'ru') === 'et' ? 'et' : 'ru' ?>">
<head>
    <meta charset="utf-8">
    <title><?= t('Регистрация', 'Registreerimine') ?></title>
    <link href="public/css/bootstrap.min.css" rel="stylesheet">
    <link href="public/css/login.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3><?= t('Регистрация', 'Registreerimine') ?></h3>
                    </div>

                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="registerAnswer">

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">
                                    <?= t('Имя', 'Nimi') ?>
                                </label>
                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control"
                                           name="name"
                                           value=""
                                           required autofocus>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="col-md-4 control-label">
                                    <?= t('Электронная почта', 'E-posti aadress') ?>
                                </label>
                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control"
                                           name="email"
                                           value=""
                                           required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-md-4 control-label">
                                    <?= t('Пароль', 'Parool') ?>
                                </label>
                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control"
                                           name="password"
                                           required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 control-label">
                                    <?= t('Подтвердите пароль', 'Kinnita parool') ?>
                                </label>
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password"
                                           class="form-control"
                                           name="confirm"
                                           required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary" name="save">
                                        <?= t('Зарегистрироваться', 'Registreeru') ?>
                                    </button>
                                </div>
                            </div>

                            <p style="padding-top:10px;">
                                <a href="./"><?= t('На главную', 'Avalehele') ?></a>
                            </p>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
$content = ob_get_clean();
include 'view/layout.php';
?>
