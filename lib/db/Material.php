<?php

namespace OCA\CBreeder\DB;

use OCP\AppFramework\Db\Entity;

class Material extends Entity
{
    /**
     * Material possible states.
     */
    const STATE_AVAILABLE = 'Доступен';
    const STATE_IN_WORK = 'В работе';
    const STATE_REVERTED = 'Возвращен на доработку';
    const STATE_COMPLETED = 'Завершён';
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
    protected $state;
    /**
     * Related stage id.
     *
     * @var int
     */
    protected $stage;
    /**
     * Filesystem mapping for material.
     *
     * @var string
     */
    protected $path;
    /**
     * Material type.
     *
     * @var string
     */
    protected $type;
    /**
     * Course part if it exists.
     *
     * @var string
     */
    protected $coursePart;
    /**
     * The sequence of material production stages, based on material type.
     * Should be overrided in nested typed classes.
     *
     * @var array
     */
    protected $stages = [];

    /**
     * Material constructor.
     */
    public function __construct()
    {
        $this->addType('courseId', 'integer');
        $this->addType('name', 'string');
        $this->addType('path', 'string');
        $this->addType('coursePart', 'string');
        $this->addType('stage', 'string');
        $this->addType('state', 'string');
        $this->addType('type', 'string');
    }

    /**
     * Update material stage up to the next one, accordingly to material type.
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function stageUp()
    {
        if ( ! $this->updateStage('up', self::STATE_AVAILABLE)) {
            throw \Exception('Возникла непредвиденная ошибка при попытке изменения стадии материала!');
        }

        return $this;
    }

    /**
     *  Update material stage down to the next one, accordingly to material type.
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function stageDown()
    {
        if ( ! $this->updateStage('down', self::STATE_REVERTED)) {
            throw \Exception('Возникла непредвиденная ошибка при попытке изменения стадии материала!');
        }

        return $this;
    }

    /**
     * Update material stage.
     *
     * @param string $direction
     * @param string $state
     *
     * @return bool
     *
     * @throws \Exception
     */
    protected function updateStage($direction, $state)
    {
        foreach ($this->stages as $key => $stage) {
            if ($this->stage === $stage) {
                switch ($direction) {
                    case 'up':
                        $newKey = $key + 1;
                        break;
                    case 'down':
                        $newKey = $key - 1;
                        break;
                    default:
                        $newKey = $key;
                }
                if (isset($this->stages[$key + 1])) {
                    $this->stage = $this->stages[$newKey];
                    $this->state = $state;
                    break;
                } else {
                    throw \Exception('Стадия материала не существует!');
                }
            }
            throw \Exception('Искомая стадия материала не найдена!');
        }

        return true;
    }
}
