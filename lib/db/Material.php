<?php

namespace OCA\CBreeder\DB;

use OCP\AppFramework\Db\Entity;

class Material extends Entity
{
    /**
     * Material name.
     *
     * @var string
     */
    protected $name;
    /**
     * Related course id.
     *
     * @var int
     */
    protected $courseId;
    /**
     * Related state id.
     *
     * @var int
     */
    protected $stateId;
    /**
     * Related stage id.
     *
     * @var int
     */
    protected $stageId;
    /**
     * Filesystem mapping for material.
     *
     * @var string
     */
    protected $path;
    /**
     * Related type id.
     *
     * @var int
     */
    protected $typeId;
    /**
     * Course part if it exists.
     *
     * @var string
     */
    protected $coursePart;

    /**
     * Material constructor.
     */
    public function __construct()
    {
        $this->addType('courseId', 'integer');
        $this->addType('stateId', 'integer');
        $this->addType('stageId', 'integer');
        $this->addType('typeId', 'integer');
        $this->addType('coursePart', 'string');
    }
}
