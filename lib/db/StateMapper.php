<?php

namespace OCA\Kranslations\DB;

use OCP\AppFramework\Db\Mapper;
use OCP\IDBConnection;

class StateMapper extends Mapper
{
    /**
     * StateMapper constructor.
     *
     * @param \OCP\IDBConnection $db
     */
    public function __construct(IDBConnection $db)
    {
        parent::__construct($db, 'kranslations_states');
    }

    /**
     * Find state.
     *
     * @param int $id
     *
     * @return \OCP\AppFramework\Db\Entity
     */
    public function find($id)
    {
        $sql = 'SELECT * FROM `*PREFIX*kranslations_states`'.
            'WHERE `id` = ?';

        return $this->findEntity($sql, [$id]);
    }

    /**
     * Find all states.
     *
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return array
     */
    public function findAll($limit = null, $offset = null)
    {
        $sql = 'SELECT * FROM `*PREFIX*kranslations_states`';

        return $this->findEntities($sql, $limit, $offset);
    }
}
