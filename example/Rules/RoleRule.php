<?php
namespace MatiosFree\App\Rules;


use MatiosFree\LRbac\Contracts\IRbacRuleContract;

class RoleRule implements IRbacRuleContract {

    public function execute($user, $item, $arguments): bool {
        return $user->role === $item->getName();
    }

}