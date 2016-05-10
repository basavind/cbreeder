<?php
/**
 * ownCloud - cbreeder
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author    Dmitry Savin <basavind@gmail.com>
 * @copyright Dmitry Savin 2016
 */

/**
 * Create your routes in here. The name is the lowercase name of the controller
 * without the controller part, the stuff after the hash is the method.
 * e.g. page#index -> OCA\CBreeder\Controller\PageController->index()
 *
 * The controller class has to be registered in the application.php file since
 * it's instantiated in there
 */
return [
    'routes' => [
        ['name' => 'page#index', 'url' => '/', 'verb' => 'GET'],
        ['name' => 'page#do_echo', 'url' => '/echo', 'verb' => 'POST'],
        ['name' => 'desktop#courses', 'url' => '/desktop/courses', 'verb' => 'GET'],
        ['name' => 'desktop#course', 'url' => '/desktop/courses/{anchor}', 'verb' => 'GET'],
    ]
];
