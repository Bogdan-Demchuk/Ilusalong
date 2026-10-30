<?php

if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'ru';
}

if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];

    if (in_array($lang, ['ru', 'et'], true)) {
        $_SESSION['lang'] = $lang;
    }

    $url = parse_url($_SERVER['REQUEST_URI']);
    $path = $url['path'] ?? '/';
    $query = [];

    if (!empty($url['query'])) {
        parse_str($url['query'], $query);
    }

    unset($query['lang']);

    $redirectUrl = $path;

    if (!empty($query)) {
        $redirectUrl .= '?' . http_build_query($query);
    }

    header('Location: ' . $redirectUrl);
    exit;
}


function t($ru, $et)
{
    return ($_SESSION['lang'] ?? 'ru') === 'et' ? $et : $ru;
}


function languageUrl($lang)
{
    $url = parse_url($_SERVER['REQUEST_URI']);
    $path = $url['path'] ?? '/';
    $query = [];

    if (!empty($url['query'])) {
        parse_str($url['query'], $query);
    }

    $query['lang'] = $lang;

    return $path . '?' . http_build_query($query);
}