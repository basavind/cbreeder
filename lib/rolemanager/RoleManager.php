<?php

namespace OCA\CBreeder\RoleManager;

use OCP\IGroupManager;
use OCP\IUserSession;

/**
 * Class Manager.
 */
class RoleManager
{
    /**
     * @var string
     */
    private $userId;
    /**
     * @var \OCP\IGroupManager
     */
    private $groupManager;
    /**
     * @var \OCP\IUserSession
     */
    private $userSession;

    /**
     * RoleManager constructor.
     *
     * @param \OCP\IGroupManager $groupManager
     * @param \OCP\IUserSession  $userSession
     */
    public function __construct(IGroupManager $groupManager, IUserSession $userSession)
    {
        $this->userSession = $userSession;
        $this->userId = $this->userSession->getUser()->getUID();
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
            if ($this->groupManager->isInGroup($this->userId, $params['group'])) {
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
            if ($this->groupManager->isInGroup($this->userId, $params['group'])) {
                $stages = array_merge($stages, $params['stages']);
            }
        }

        return $stages;
    }
}
