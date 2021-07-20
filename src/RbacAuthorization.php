<?php
namespace MatiosFree\LRbac;

use Exception;
use MatiosFree\LRbac\Contracts\IRbacItemContract;
use MatiosFree\LRbac\Contracts\IRbacRuleContract;

abstract class RbacAuthorization {

    /**
     * Get list of Permissions
     *
     * @return array
     */
    abstract public function getPermissions(): array;

    /**
     * Get list of roles
     *
     * @return array
     */
    abstract public function getRoles(): array;

    /**
     * Get list with default roles for any user
     *
     * @return array
     */
    abstract public function getDefaultRoles(): array;

    /**
     * Check if user has an access
     *
     * @throws Exception
     */
    public function checkAccess($user, $ability, $arguments = []): bool {

        if (!isset($this->getPermissions()[$ability]) && !isset($this->getRoles()[$ability])) {
            return false;
        }

        $roleItem = $this->getRoles()[$ability] ?? null;

        if ($roleItem && !$this->executeRule($user, new RbacRoleItem(array_merge($roleItem, ['name' => $ability])), $arguments)) {
            return false;
        }

        $permissionItem = $this->getPermissions()[$ability] ?? null;

        if ($permissionItem && !$this->executeRule($user, new RbacPermissionItem(array_merge($permissionItem, ['name' => $ability])), $arguments)) {
            return false;
        }

        if (in_array($ability, $this->getDefaultRoles())) {
            return true;
        }

        foreach (array_merge($this->getRoles(), $this->getPermissions()) as $role => $roleItem) {
            if (in_array($ability, $roleItem['children'] ?? []) && $this->checkAccess($user, $role, $arguments)) {
                return true;
            }
        }

        return false;
    }


    /**
     * Get result of executed rule
     *
     * @param $user
     * @param IRbacItemContract $item
     * @param $arguments
     * @return bool
     * @throws Exception
     */
    protected function executeRule($user, IRbacItemContract $item, $arguments): bool {
        if ($item->getRuleName() === null) {
            return true;
        }

        $rule = $this->getRule($item->getRuleName());

        if ($rule instanceof IRbacRuleContract) {
            return $rule->execute($user, $item, $arguments);
        }

        throw new \Exception("Rule not found: {$item->getRuleName()}");
    }

    /**
     * Get rule instance by the name of the class
     *
     * @param $ruleName
     * @return IRbacRuleContract|null
     */
    protected function getRule($ruleName):? IRbacRuleContract {
        return new $ruleName();
    }

}