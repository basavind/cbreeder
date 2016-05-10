<?php

namespace OCA\CBreeder\DB;

use OCP\AppFramework\Db\Mapper;
use OCP\IDBConnection;

class StageMapper extends Mapper
{
    /**
     * StageMapper constructor.
     *
     * @param \OCP\IDBConnection $db
     */
    public function __construct(IDBConnection $db)
    {
        parent::__construct($db, 'cbreeder_stages');
    }

    /**
     * Find material stage.
     *
     * @param int $id
     *
     * @return \OCP\AppFramework\Db\Entity
     */
    public function find($id)
    {
        $sql = 'SELECT * FROM `*PREFIX*cbreeder_stages`'.
            'WHERE `id` = ?';

        return $this->findEntity($sql, [$id]);
    }

    /**
     * Find all available stages.
     *
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return array
     */
    public function findAll($limit = null, $offset = null)
    {
        $sql = 'SELECT * FROM `*PREFIX*cbreeder_stages`';

        return $this->findEntities($sql, $limit, $offset);
    }
}
