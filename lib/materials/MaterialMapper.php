<?php

namespace OCA\Cbreeder\Materials;

use OCA\CBreeder\RoleManager\RoleManager;
use OCP\AppFramework\Db\Mapper;
use OCP\IDBConnection;

class MaterialMapper extends Mapper
{
    /**
     * @var \OCA\CBreeder\RoleManager\RoleManager
     */
    private $roleManager;

    /**
     * MaterialMapper constructor.
     *
     * @param \OCP\IDBConnection                    $db
     * @param \OCA\CBreeder\RoleManager\RoleManager $roleManager
     */
    public function __construct(IDBConnection $db, RoleManager $roleManager)
    {
        parent::__construct($db, 'cbreeder_materials');
        $this->roleManager = $roleManager;
    }

    /**
     * Find material.
     *
     * @param int $id
     *
     * @return \OCP\AppFramework\Db\Entity
     */
    public function find($id)
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE `id` = ?";

        return $this->findEntity($sql, [$id]);
    }

    /**
     * Find all materials.
     *
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return array
     */
    public function findAll($limit = null, $offset = null)
    {
        $sql = "SELECT * FROM {$this->tableName}";

        return $this->findEntities($sql, [], $limit, $offset);
    }

    /**
     * Get only allowed for user (role) materials.
     *
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return array
     */
    public function getAllowed($limit = null, $offset = null)
    {
        $stages = $this->roleManager->getAllowedStages();
        $binds = implode(',', array_fill(0, count($stages), '?'));
        $sql = "SELECT * FROM {$this->tableName} WHERE stage IN ({$binds})";

        return $this->findEntities($sql, $stages, $limit, $offset);
    }

    public function getCoursesFor($section, $limit = null, $offset = null)
    {
        if (empty($section)) {
            throw new \Exception();
        }

        $stages = $this->roleManager->getAllowedStages();
        $binds = implode(',', array_fill(0, count($stages), '?'));
        $sql = 'SELECT m.course as name, '
            .'m.course_slug as slug, '
            ."COUNT(CASE WHEN state LIKE 'Доступен' THEN 1 ELSE NULL END) as available, "
            ."COUNT(CASE WHEN state LIKE 'В работе' THEN 1 ELSE NULL END) as in_work, "
            ."COUNT(CASE WHEN state LIKE 'Возвращен на доработку' THEN 1 ELSE NULL END) as reverted, "
            ."COUNT(CASE WHEN state LIKE 'Завершён' THEN 1 ELSE NULL END) as completed "
            ."FROM {$this->tableName} m "
            .'WHERE m.section_slug = ? '
            ."AND m.stage in ({$binds}) "
            .'GROUP BY m.course_slug ';

        $params = array_merge([$section], $stages);

        return $this->execute($sql, $params, $limit, $offset)->fetchAll();
    }

    public function getSectionsStats($limit = null, $offset = null)
    {
        $stages = $this->roleManager->getAllowedStages();
        $binds = implode(',', array_fill(0, count($stages), '?'));
        $sql = 'SELECT m.section as name, m.section_slug as slug, '
            ."COUNT(CASE WHEN state LIKE 'Доступен' THEN 1 ELSE NULL END) as available, "
            ."COUNT(CASE WHEN state LIKE 'В работе' THEN 1 ELSE NULL END) as in_work, "
            ."COUNT(CASE WHEN state LIKE 'Возвращен на доработку' THEN 1 ELSE NULL END) as reverted, "
            ."COUNT(CASE WHEN state LIKE 'Завершён' THEN 1 ELSE NULL END) as completed "
            ."FROM {$this->tableName} m "
            ."WHERE m.stage in ({$binds}) "
            .'GROUP BY m.section';

        $params = array_merge($stages);

        return $this->execute($sql, $params, $limit, $offset)->fetchAll();
    }

    public function getSectionNameFor($slug)
    {
        if (empty($slug)) {
            throw new \Exception();
        }
        $sql = 'SELECT DISTINCT m.section as section_name '
            ."FROM {$this->tableName} m "
            .'WHERE m.`section_slug` LIKE ?;';
        $result = $this->execute($sql, [$slug])->fetch();

        return $result['section_name'];
    }

    public function getCourseNameFor($slug)
    {
        if (empty($slug)) {
            throw new \Exception();
        }
        $sql = 'SELECT DISTINCT m.course as course_name '
            ."FROM {$this->tableName} m "
            .'WHERE m.`course_slug` LIKE ?;';
        $result = $this->execute($sql, [$slug])->fetch();

        return $result['course_name'];
    }
}
