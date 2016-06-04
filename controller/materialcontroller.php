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

use OCA\CBreeder\Materials\Material;
use OCA\Cbreeder\Materials\MaterialMapper;
use OCA\CBreeder\Materials\UndefinedStageException;
use OCA\CBreeder\RoleManager\RoleManager;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Http\TemplateResponse;
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
     * @var \OCA\CBreeder\RoleManager\RoleManager
     */
    private $roleManager;

    /**
     * DesktopController constructor.
     *
     * @param string                                $AppName
     * @param \OCP\IRequest                         $request
     * @param \OCA\Cbreeder\DB\MaterialMapper       $mapper
     * @param \OCA\CBreeder\RoleManager\RoleManager $roleManager
     * @param                                       $UserId
     *
     * @internal param \OCA\CBreeder\DB\MaterialMapper $materialMapper
     */
    public function __construct($AppName,
                                IRequest $request,
                                MaterialMapper $mapper,
                                RoleManager $roleManager,
                                $UserId)
    {
        parent::__construct($AppName, $request);
        $this->userId = $UserId;
        $this->mapper = $mapper;
        $this->roleManager = $roleManager;
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
     * @param $section
     * @param $course
     *
     * @return \OCP\AppFramework\Http\TemplateResponse
     */
    public function index($section, $course)
    {
        $sectionName = $this->mapper->getSectionNameFor($section);
        $courseName = $this->mapper->getCourseNameFor($course);
        $materials = $this->mapper->getAllowed();
        $params = [
            'user' => $this->userId,
            'sectionName' => $sectionName,
            'courseName' => $courseName,
            'course' => [
                'section' => 'Mathematics',
                'name' => 'Differential equations',
            ],
            'materials' => $materials,
        ];

        return new TemplateResponse('cbreeder', 'material/index', $params);
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
     * @param $direction
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

        try {
            $material->$method();
        } catch (UndefinedStageException $e) {
            return new DataResponse([
                'ok' => false,
                'material' => 'Material can not be staged '.$direction,
            ]);
        }

        $this->mapper->update($material);

        if (in_array($material->getStage(), $this->roleManager->getAllowedStages())) {
            return new DataResponse([
                'ok' => true,
                'material' => $material->toArray(),
            ]);
        } else {
            return new DataResponse([
                'ok' => true,
                'material' => 'Not allowed',
            ]);
        }
    }
}
