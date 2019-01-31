<?php

use Blaj\BlajMVC\Core\Utils\Translations;

$translations['pl'] = [
    'not_exist' => 'Tłumaczenie {translation} nie istnieje!',
    'app_title' => 'BlajMVC - Strona główna'
];

$translations['en'] = [
    'not_exist' => 'Translation {translation} do not exist!',
    'app_title' => 'BlajMVC - Home page'
];

Translations::setTranslations($translations);
