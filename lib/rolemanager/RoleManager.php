<?php

namespace OCA\CBreeder\RoleManager;

use OC;
use OC_User;

/**
 * Class Manager.
 */
class RoleManager
{
    /**
     * Role bindings.
     *
     * @array
     */
    const roles = [
        'editor' => [
            'group' => 'Редактор',
            'stages' => ['На редакции'],
        ],
        'corrector' => [
            'group' => 'Корректор',
            'stages' => ['На коррекции'],
        ],
        'layouter' => [
            'group' => 'Верстальщик',
            'stages' => ['На вёрстке'],
        ],
        'cutter' => [
            'group' => 'Монтажёр',
            'stages' => ['На монтаже'],
        ],
        'publisher' => [
            'group' => 'Выпускающий редактор',
            'stages' => ['На выпуске'],
        ],
    ];

    /**
     * Get associated with user roles.
     *
     * @return array
     */
    public static function getRoles()
    {
        $roles = [];
        $user = OC_User::getUser();
        foreach (self::roles as $role => $params) {
            if (OC::$server->getGroupManager()->isInGroup($user, $params['group'])) {
                $roles[] = $role;
            }
        }

        return $roles;
    }

    /**
     * Get allowed for user material stages.
     *
     * @return array
     */
    public static function getAllowedStages()
    {
        $stages = [];
        $user = OC_User::getUser();
        foreach (self::roles as $role => $params) {
            if (OC::$server->getGroupManager()->isInGroup($user, $params['group'])) {
                $stages = array_merge($stages, $params['stages']);
            }
        }

        return $stages;
    }
}
