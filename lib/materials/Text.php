<?php

namespace OCA\CBreeder\Materials;

use OCA\CBreeder\DB\Material;

class Text extends Material
{
    public static $stages = [
        'Переведён',
        'Редактируется',
        'Отредактирован',
        'Корректируется',
        'Откорректирован',
        'Верстается',
        'Предвыпуск',
        'Выпущен',
    ];
}
