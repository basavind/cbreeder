<?php

namespace OCA\CBreeder\Materials;

use OCA\CBreeder\DB\Material;

class Presentation extends Material
{
    public $stages = [
        'Переведён',
        'Редактируется',
        'Отредактирован',
        'Корректируется',
        'Откорректирован',
        'Предвыпуск',
        'Выпущен',
    ];

    protected function getClassName()
    {
        return self::class;
    }
}
