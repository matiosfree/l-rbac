<?php
namespace MatiosFree\LRbac;


use MatiosFree\LRbac\Contracts\IRbacItemContract;

class RbacPermissionItem implements IRbacItemContract {

    /**
     * @var string the name of the item. This must be globally unique.
     */
    protected $name;

    /**
     * @var string the item description
     */
    protected $description;

    /**
     * @var string name of the rule associated with this item
     */
    protected $ruleName;

    public function __construct(array $roleItem) {
        $this->name = $roleItem['name'] ?? null;
        $this->description = $roleItem['description'] ?? null;
        $this->ruleName = $roleItem['ruleName'] ?? null;
    }

    public function getName():? string  {
        return $this->name;
    }

    public function getDescription():? string  {
        return $this->description;
    }

    public function getRuleName():? string  {
        return $this->ruleName;
    }

}