<?php
namespace MatiosFree\LRbac\Contracts;


interface IRbacItemContract {

    public function getName():? string;

    public function getDescription():? string;

    public function getRuleName():? string;

}