<?php
/**
 * ownCloud - kranslations
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author    Dmitry Savin <basavind@gmail.com>
 * @copyright Dmitry Savin 2016
 */

namespace OCA\Kranslations\Controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;

class DesktopController extends Controller
{


    private $userId;

    public function __construct($AppName, IRequest $request, $UserId)
    {
        parent::__construct($AppName, $request);
        $this->userId = $UserId;
    }

    /**
     * CAUTION: the @Stuff turns off security checks; for this page no admin is
     *          required and no CSRF check. If you don't know what CSRF is, read
     *          it up in the docs or you might create a security hole. This is
     *          basically the only required method to add this exemption, don't
     *          add it to any other method if you don't exactly know what it does
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
                        'reverted' => 1
                    ]
                ]
            ]
        ];
        return new TemplateResponse('kranslations', 'desktop.courses', $params);  // templates/main.php
    }

    /**
     * CAUTION: the @Stuff turns off security checks; for this page no admin is
     *          required and no CSRF check. If you don't know what CSRF is, read
     *          it up in the docs or you might create a security hole. This is
     *          basically the only required method to add this exemption, don't
     *          add it to any other method if you don't exactly know what it does
     *
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function course($anchor)
    {
        $params = ['user' => $this->userId];
        return new TemplateResponse('kranslations', 'desktop.course', $params);  // templates/main.php
    }


    /**
     * Simply method that posts back the payload of the request
     *
     * @NoAdminRequired
     */
    public function doEcho($echo)
    {
        return new DataResponse(['echo' => $echo]);
    }


}
