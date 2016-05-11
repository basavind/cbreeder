<?php

namespace OCA\CBreeder\Materials;

use OCA\CBreeder\DB\Material;

class Presentation extends Material
{
    public static $stages = [
        'Переведён',
        'Редактируется',
        'Отредактирован',
        'Корректируется',
        'Откорректирован',
        'Предвыпуск',
        'Выпущен',
    ];
}
