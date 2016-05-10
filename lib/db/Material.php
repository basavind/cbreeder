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

        $this->init();
    }

    private function init()
    {
        $this->setStage($this->stages[0]);
        $this->setState(self::STATE_AVAILABLE);
        $this->setType($this->typeValue);
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
        $stageKey = array_search($this->stage, $this->stages);

        switch ($direction) {
            case 'up':
                $newKey = $stageKey + 1;
                break;
            case 'down':
                $newKey = $stageKey - 1;
                break;
            default:
                $newKey = $stageKey;
        }

        if (isset($this->stages[$newKey])) {
            $newStage = $this->stages[$newKey];
            $this->setStage($newStage);
            $this->setState($state);
        } else {
            throw \Exception('Стадия материала не существует!');
        }

        return true;
    }
}
