<?php

namespace OCA\CBreeder\Materials;

use OCA\CBreeder\DB\Material;

class Text extends Material
{
    public static $stages = [
        'На редакции',
        'На коррекции',
        'На вёрстке',
        'На выпуске',
    ];
}
