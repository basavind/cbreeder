<?php

/*
 * Main config file
 */
return [
    'roles' => [
        'editor' => [
            'group' => 'Редактор',
            'stages' => ['На редакции'],
        ],
        'corrector' => [
            'group' => 'Корректор',
            'stages' => ['На коррекции'],
        ],
        'layouter' => [
            'group' => 'Верстальщик',
            'stages' => ['На вёрстке'],
        ],
        'cutter' => [
            'group' => 'Монтажёр',
            'stages' => ['На монтаже'],
        ],
        'publisher' => [
            'group' => 'Выпускающий редактор',
            'stages' => ['На выпуске'],
        ],
    ],
];
