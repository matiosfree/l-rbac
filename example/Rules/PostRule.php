<?php
namespace MatiosFree\App\Rules;


use MatiosFree\LRbac\Rules\RbacRule;

class PostRule extends RbacRule {

    /**
     * @var string the name of the item. This must be globally unique.
     */
    protected string $name = 'postRule';

    public function execute($user, $item, $arguments): bool {
        return $user->id === $arguments['post']->user_id;
    }

}