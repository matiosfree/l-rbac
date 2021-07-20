<?php
namespace MatiosFree\LRbac\Rules;


use MatiosFree\LRbac\Contracts\IRbacRuleContract;

abstract class RbacRule implements IRbacRuleContract {

    /**
     * @var string the name of the item. This must be globally unique.
     */
    protected string $name;

    public function getName():? string {
        return $this->name;
    }

    abstract public function execute($user, $item, $arguments): bool;

}