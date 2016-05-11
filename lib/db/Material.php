<?php

namespace OCA\CBreeder\DB;

use OCP\AppFramework\Db\Entity;

abstract class Material extends Entity
{
    /**
     * Material possible states.
     */
    const STATE_AVAILABLE = 'Доступен';
    const STATE_IN_WORK = 'В работе';
    const STATE_REVERTED = 'Возвращен на доработку';
    const STATE_COMPLETED = 'Завершён';

    /**
     * DB fields.
     */
    protected $name;
    protected $courseId;
    protected $state;
    protected $stage;
    protected $path;
    protected $type;
    protected $class;
    protected $coursePart;

    /**
     * The sequence of material production stages, based on material type.
     * Should be overrided in nested typed classes.
     *
     * @var array
     */
    protected $stages = [];

    public function __construct()
    {
        $this->addType('courseId', 'integer');
        $this->addType('name', 'string');
        $this->addType('path', 'string');
        $this->addType('coursePart', 'string');
        $this->addType('stage', 'string');
        $this->addType('state', 'string');
        $this->addType('type', 'string');
        $this->addType('class', 'string');

        $this->init();
    }

    private function init()
    {
        if ( ! count($this->stages)) {
            throw new \LogicException('Class does not realize production scenario!');
        }

        $this->setStage($this->stages[0]);
        $this->setState(self::STATE_AVAILABLE);
        $this->setClass(get_class($this));
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
            throw \Exception('An unexpected error occurred while attempting to change the stage of the material!');
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
            throw \Exception('An unexpected error occurred while attempting to change the stage of the material!');
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
            throw \Exception('The material stage does not exist!');
        }

        return true;
    }

    /**
     * Maps the keys of the row array to the attributes.
     *
     * @param array $row the row to map onto the entity
     *
     * @return static
     *
     * @throws \Exception
     *
     * @since 7.0.0
     */
    public static function fromRow(array $row)
    {
        if ( ! isset($row['class']) || ! class_exists($row['class'])) {
            throw new \Exception('Material type class does not exists!');
        }

        $class = $row['class'];
        $instance = new $class();

        foreach ($row as $key => $value) {
            $prop = ucfirst($instance->columnToProperty($key));
            $setter = 'set'.$prop;
            $instance->$setter($value);
        }

        $instance->resetUpdatedFields();

        return $instance;
    }
}
