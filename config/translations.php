<?php

use Blaj\BlajMVC\Core\Utils\Translations;

$translations['pl'] = [
    'not_exist' => 'Tłumaczenie {translation} nie istnieje!',
    'app_title' => 'BlajMVC - Strona główna',
    'add_article' => 'Dodaj nowy artykuł'
];

$translations['en'] = [
    'not_exist' => 'Translation {translation} do not exist!',
    'app_title' => 'BlajMVC - Home page',
    'add_article' => 'Add new article'
];

Translations::setTranslations($translations);
