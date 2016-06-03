<?php

namespace tests\unit;

use OCA\CBreeder\RoleManager\RoleManager;
use PHPUnit_Framework_TestCase;

/**
 * Class RoleManagerTest.
 */
class RoleManagerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $groupManagerMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $userSessionMock;

    /**
     * Test SetUp.
     */
    public function setUp()
    {
        $this->groupManagerMock = $this->getMockBuilder(\OC\Group\Manager::class)
            ->setMethods(['isInGroup'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->userSessionMock = $this->getMockBuilder(\OC\User\Session::class)
            ->setMethods(['getUser'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    /** @test */
    public function it_returns_all_available_roles_if_user_is_in_all_groups()
    {
        $this->groupManagerMock->expects($this->any())->method('isInGroup')->will($this->returnValue(true));
        $roleManager = new RoleManager($this->groupManagerMock, $this->userSessionMock);
        $assertedRoles = array_keys(config('roles'));
        $diff = array_diff($assertedRoles, $roleManager->getRoles());

        $this->assertEmpty($diff);
    }

    /** @test */
    public function it_returns_empty_array_of_roles_if_user_not_in_any_group()
    {
        $this->groupManagerMock->expects($this->any())->method('isInGroup')->will($this->returnValue(false));
        $roleManager = new RoleManager($this->groupManagerMock, $this->userSessionMock);

        $this->assertEmpty($roleManager->getRoles());
    }

    /** @test */
    public function it_returns_all_available_stages_if_user_is_in_all_groups()
    {
        $this->groupManagerMock->expects($this->any())->method('isInGroup')->will($this->returnValue(true));
        $roleManager = new RoleManager($this->groupManagerMock, $this->userSessionMock);
        $assertedStages = array_values(array_map(function ($val) {return $val['stages'][0];}, config('roles')));
        $diff = array_diff($assertedStages, $roleManager->getAllowedStages());

        $this->assertEmpty($diff);
    }

    /** @test */
    public function it_returns_empty_array_of_stages_if_user_not_in_any_group()
    {
        $this->groupManagerMock->expects($this->any())->method('isInGroup')->will($this->returnValue(false));
        $roleManager = new RoleManager($this->groupManagerMock, $this->userSessionMock);

        $this->assertEmpty($roleManager->getAllowedStages());
    }
}
