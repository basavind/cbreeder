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
     * Get associated with user roles.
     *
     * @return array
     */
    public function getRoles()
    {
        $roles = [];
        $user = OC_User::getUser();
        foreach (config('roles') as $role => $params) {
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
    public function getAllowedStages()
    {
        $stages = [];
        $user = OC_User::getUser();
        foreach (config('roles') as $role => $params) {
            if (OC::$server->getGroupManager()->isInGroup($user, $params['group'])) {
                $stages = array_merge($stages, $params['stages']);
            }
        }

        return $stages;
    }
}
