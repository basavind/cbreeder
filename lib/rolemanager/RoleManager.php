<?php

namespace OCA\CBreeder\RoleManager;

use OC\Group\Manager as GroupManager;
use OC\User\Session as UserSession;

/**
 * Class Manager.
 */
class RoleManager
{

    private $user;
    private $groupManager;

    public function __construct(GroupManager $groupManager, UserSession $session)
    {
        $this->user = $session->getUser();
        $this->groupManager = $groupManager;
    }
    /**
     * Get associated with user roles.
     *
     * @return array
     */
    public function getRoles()
    {
        $roles = [];
        foreach (config('roles') as $role => $params) {
            if ($this->groupManager->isInGroup($this->user, $params['group'])) {
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
        foreach (config('roles') as $role => $params) {
            if ($this->groupManager->isInGroup($this->user, $params['group'])) {
                $stages = array_merge($stages, $params['stages']);
            }
        }

        return $stages;
    }
}
