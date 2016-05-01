<?php

namespace OCA\Kranslations\DB;

use OCP\AppFramework\Db\Mapper;
use OCP\IDBConnection;

class SectionMapper extends Mapper
{
    /**
     * SectionMapper constructor.
     *
     * @param \OCP\IDBConnection $db
     */
    public function __construct(IDBConnection $db)
    {
        parent::__construct($db, 'kranslations_sections');
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
        $sql = 'SELECT * FROM `*PREFIX*kranslations_sections`'.
            'WHERE `id` = ?';

        return $this->findEntity($sql, [$id]);
    }

    /**
     * Find all sections.
     *
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return array
     */
    public function findAll($limit = null, $offset = null)
    {
        $sql = 'SELECT * FROM `*PREFIX*kranslations_sections`';

        return $this->findEntities($sql, $limit, $offset);
    }
}
