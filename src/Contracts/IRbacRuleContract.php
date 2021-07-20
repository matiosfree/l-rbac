<?php
namespace MatiosFree\LRbac\Contracts;


interface IRbacRuleContract {

    public function execute($user, $item, $arguments):? bool;

}