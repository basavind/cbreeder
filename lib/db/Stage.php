<?php

namespace OCA\Kranslations\DB;

use OCP\AppFramework\Db\Entity;

class Stage extends Entity
{
    /**
     * Material stage name.
     *
     * @var string
     */
    protected $name;
    /**
     * Material stage directory name.
     *
     * @var string
     */
    protected $dirName;
}
