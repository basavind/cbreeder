<?php

namespace OCA\Kranslations\DB;

use OCP\AppFramework\Db\Mapper;
use OCP\IDBConnection;

class MaterialMapper extends Mapper
{
    /**
     * MaterialMapper constructor.
     *
     * @param \OCP\IDBConnection $db
     */
    public function __construct(IDBConnection $db)
    {
        parent::__construct($db, 'kranslations_materials');
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
        $sql = 'SELECT * FROM `*PREFIX*kranslations_materials`'.
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
        $sql = 'SELECT * FROM `*PREFIX*kranslations_materials`';

        return $this->findEntities($sql, $limit, $offset);
    }
}
