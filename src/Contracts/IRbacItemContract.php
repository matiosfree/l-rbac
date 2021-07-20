<?php
namespace MatiosFree\LRbac\Contracts;


interface IRbacItemContract {

    /**
     * Get the name of the item. This must be globally unique.
     *
     * @return string|null
     */
    public function getName():? string;

    /**
     * Get the item description
     *
     * @return string|null
     */
    public function getDescription():? string;

    /**
     * Get the name of the rule associated with this item
     *
     * @return string|null
     */
    public function getRuleName():? string;

}