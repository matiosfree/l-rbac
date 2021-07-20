<?php
namespace MatiosFree\App;

use MatiosFree\App\Rules\PostRule;
use MatiosFree\App\Rules\RoleRule;
use MatiosFree\LRbac\RbacAuthorization;

class Authorization extends RbacAuthorization {

    public function getDefaultRoles(): array {
        return ['user', 'manager'];
    }

    public function getRoles(): array {
        return [
            'manager' => [
                'description' => 'Manager Role',
                'ruleName' => RoleRule::class,
                'children' => [
                    'updatePost',
                    'deletePost',
                ]
            ],
            'user' => [
                'description' => 'User Role',
                'ruleName' => RoleRule::class,
                'children' => [
                    'updateOwnPost'
                ]
            ],
        ];
    }

    public function getPermissions(): array {
        return [
            'updatePost' => [
                'description' => 'Edit any posts'
            ],
            'updateOwnPost' => [
                'description' => 'Edit own post',
                'ruleName' => PostRule::class,
                'children' => [
                    'updatePost'
                ],
            ],
            'deletePost' => [
                'description' => 'Delete any posts'
            ],
        ];
    }

}