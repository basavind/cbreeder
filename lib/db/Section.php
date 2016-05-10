<?php

namespace OCA\CBreeder\DB;

use OCP\AppFramework\Db\Entity;

class Section extends Entity
{
    /**
     * Section name.
     *
     * @var string
     */
    protected $name;
    /**
     * Filesystem mapping for material.
     *
     * @var string
     */
    protected $path;
}
