<?php
namespace MatiosFree\App\Rules;


use MatiosFree\LRbac\Rules\RbacRule;

class RoleRule extends RbacRule {

    /**
     * @var string the name of the item. This must be globally unique.
     */
    protected string $name = 'roleRule';

    public function execute($user, $item, $arguments): bool {
        return $user->role === $item->getName();
    }

}