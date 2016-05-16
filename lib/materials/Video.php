<?php

namespace OCA\CBreeder\Materials;

use OCA\CBreeder\DB\Material;

class Video extends Material
{
    public static $stages = [
        'На редакции',
        'На коррекции',
        'На монтаже',
        'На выпуске',
    ];
}
