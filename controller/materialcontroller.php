<?php

namespace OCA\CBreeder\Controller;

/*
 * ownCloud - cbreeder.
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author    Dmitry Basavin <basavind@gmail.com>
 * @copyright Dmitry Basavin 2016
 */

use OCA\CBreeder\DB\Material;
use OCA\Cbreeder\DB\MaterialMapper;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;

class MaterialController extends Controller
{
    /**
     * Auth user id.
     *
     * @var int
     */
    private $userId;

    /**
     * Map materials from db.
     *
     * @var \OCA\CBreeder\DB\MaterialMapper
     */
    private $mapper;

    private $stageDirections = [
        'up' => 'stageUp',
        'down' => 'stageDown',
    ];

    /**
     * DesktopController constructor.
     *
     * @param string                          $AppName
     * @param \OCP\IRequest                   $request
     * @param \OCA\Cbreeder\DB\MaterialMapper $mapper
     * @param                                 $UserId
     *
     * @internal param \OCA\CBreeder\DB\MaterialMapper $materialMapper
     */
    public function __construct($AppName, IRequest $request, MaterialMapper $mapper, $UserId)
    {
        parent::__construct($AppName, $request);
        $this->userId = $UserId;
        $this->mapper = $mapper;
    }

    /**
     * CAUTION: the @Stuff turns off security checks; for this page no admin is
     *          required and no CSRF check. If you don't know what CSRF is, read
     *          it up in the docs or you might create a security hole. This is
     *          basically the only required method to add this exemption, don't
     *          add it to any other method if you don't exactly know what it does.
     *
     * @NoAdminRequired
     * @NoCSRFRequired
     *
     * @param $materialId
     *
     * @return \OCP\AppFramework\Http\DataResponse
     */
    public function stage($materialId, $direction)
    {
        if ( ! key_exists($direction, $this->stageDirections)) {
            return new DataResponse([
                'ok' => 'false',
                'message' => 'Stage direction doesn\'t set',
            ]);
        }

        /** @var Material $material */
        $material = $this->mapper->find($materialId);

        $method = $this->stageDirections[$direction];
        if ( ! method_exists($material, $method)) {
            return new DataResponse([
                'ok' => false,
                'message' => 'Method doesn\'t exists',
            ]);
        }

        $material->$method();
        $this->mapper->update($material);

        return new DataResponse([
            'ok' => true,
            'material' => $material->toArray(),
        ]);
    }
}
