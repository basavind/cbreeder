<?php

namespace OCA\CBreeder\Controller;

/*
 * ownCloud - cbreeder.
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author    Dmitry Savin <basavind@gmail.com>
 * @copyright Dmitry Savin 2016
 */

use OCA\Cbreeder\DB\MaterialMapper;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;

class DesktopController extends Controller
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
     */
    public function courses()
    {
        $params = [
            'user' => $this->userId,
            'courses' => [
                [
                    'anchor' => 1,
                    'section' => 'Mathematics',
                    'name' => 'Differential equations',
                    'materials' => [
                        'total' => 5,
                        'available' => 3,
                        'completed' => 2,
                        'reverted' => 1,
                    ],
                ],
            ],
        ];

        return new TemplateResponse('cbreeder', 'desktop.courses', $params);  // templates/main.php
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
     */
    public function course($anchor)
    {
        $materials = $this->mapper->findAll();
        $params = [
            'user' => $this->userId,
            'course' => [
                'section' => 'Mathematics',
                'name' => 'Differential equations',
            ],
            'materials' => $materials,
        ];

        return new TemplateResponse('cbreeder', 'desktop.course', $params);  // templates/main.php
    }

    /**
     * Simply method that posts back the payload of the request.
     *
     * @NoAdminRequired
     */
    public function doEcho($echo)
    {
        return new DataResponse(['echo' => $echo]);
    }
}
