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

use OCA\Cbreeder\Materials\MaterialMapper;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;

/**
 * Class SectionController.
 */
class CourseController extends Controller
{
    /**
     * @var
     */
    private $userId;
    /**
     * @var \OCA\Cbreeder\Materials\MaterialMapper
     */
    private $mapper;

    /**
     * SectionController constructor.
     *
     * @param string                                 $AppName
     * @param \OCP\IRequest                          $request
     * @param \OCA\Cbreeder\Materials\MaterialMapper $mapper
     * @param                                        $UserId
     */
    public function __construct($AppName,
                                IRequest $request,
                                MaterialMapper $mapper,
                                $UserId)
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
     * @param $section
     *
     * @return \OCP\AppFramework\Http\TemplateResponse
     * @throws \Exception
     */
    public function index($section)
    {
        $courses = $this->mapper->getCoursesFor($section);
        $params = [
            'user' => $this->userId,
            'courses' => $courses,
        ];

        return new TemplateResponse('cbreeder', 'course/index', $params);
    }
}
