<?php

namespace OCA\Cbreeder\DB;

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
        $sql = 'SELECT * FROM `*PREFIX*cbreeder_materials`'.
            'WHERE `id` = ?';

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
        $sql = 'SELECT * FROM `*PREFIX*cbreeder_materials`';

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
        $sql = "SELECT * FROM `*PREFIX*cbreeder_materials` WHERE stage IN ({$binds})";

        return $this->findEntities($sql, $stages, $limit, $offset);
    }

    public function getStats($limit = null, $offset = null)
    {
        $sql = 'SELECT c.id, c.name, ' .
            'COUNT(CASE WHEN state LIKE \'Доступен\' THEN 1 ELSE NULL END) as available, ' .
            'COUNT(CASE WHEN state LIKE \'В работе\' THEN 1 ELSE NULL END) as in_work, ' .
            'COUNT(CASE WHEN state LIKE \'Возвращен на доработку\' THEN 1 ELSE NULL END) as reverted, ' .
            'COUNT(CASE WHEN state LIKE \'Завершён\' THEN 1 ELSE NULL END) as completed ' .
            'FROM `*PREFIX*cbreeder_materials` m ' .
            'INNER JOIN `*PREFIX*cbreeder_courses` c ON c.id = m.course_id ' .
            'INNER JOIN `*PREFIX*cbreeder_sections` s on s.id = c.section_id ' .
            'GROUP BY course_id';

        return $this->execute($sql, [], $limit, $offset)->fetchAll();
    }
}
