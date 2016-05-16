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
}
