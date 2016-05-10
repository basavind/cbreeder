<?php

namespace OCA\CBreeder\DB;

use OCP\AppFramework\Db\Entity;

class State extends Entity
{
    /**
     * Material state name.
     *
     * @var string
     */
    protected $name;
    /**
     * Display name for material state.
     *
     * @var string
     */
    protected $displayName;
}
