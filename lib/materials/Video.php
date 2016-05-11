<?php

namespace OCA\CBreeder\Materials;

use OCA\CBreeder\DB\Material;

class Video extends Material
{
    public static $stages = [
        'Переведён',
        'Редактируется',
        'Отредактирован',
        'Корректируется',
        'Откорректирован',
        'Монтируется',
        'Предвыпуск',
        'Выпущен',
    ];
}
