<?php

namespace OCA\Kranslations\DB;

use OCP\AppFramework\Db\Entity;

class Course extends Entity
{
    /**
     * Course name.
     *
     * @var string
     */
    protected $name;
    /**
     * Related section id.
     *
     * @var int
     */
    protected $sectionId;
    /**
     * Filesystem mapping for material.
     *
     * @var
     */
    protected $path;
}
