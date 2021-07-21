<?php
namespace MatiosFree\App\Rules;


use MatiosFree\LRbac\Contracts\IRbacRuleContract;

class OwnPostRule implements IRbacRuleContract {

    public function execute($user, $item, $arguments): bool {
        return $user->id === $arguments['post']->author_id;
    }

}