l-rbac
------------

The [RBAC](https://en.wikipedia.org/wiki/Role-based_access_control) implementation for Laravel. Based on Laravel Abilities\Gates (v5+).
This package implements a General Hierarchical RBAC, following the [implementation in Yii2](https://www.yiiframework.com/doc/guide/2.0/en/security-authorization#rbac)


[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Total Downloads][ico-downloads]][link-downloads]


Installation
------------

1. The preferred way to install this package is through [composer](http://getcomposer.org/download/).
Either run
```
php composer require matiosfree/l-rbac "*"
```

or add

```
"matiosfree/l-rbac": "*"
```
to the require section of your composer.json.

2. Add the service provider to config/app.php.
```php
MatiosFree\LRbac\RbacServiceProvider::class,
```

3. Publish service provider with command:
~~~
php artisan vendor:publish --provider="MatiosFree\LRbac\RbacServiceProvider"
~~~

4. Create Authorization class that extends **MatiosFree\LRbac\RbacAuthorization**:
```php
<?php
namespace App\Classes;

use App\Classes\Rules\OwnPostRule;
use App\Classes\Rules\RoleRule;
use MatiosFree\LRbac\RbacAuthorization;

class Authorization extends RbacAuthorization {

    public function getDefaultRoles(): array {
        return ['user', 'manager'];
    }

    public function getRoles(): array {
        return [
            'manager' => [
                'description' => 'Manager Role', // optional property
                'ruleName' => RoleRule::class, // optional property that contains the rule for the role\action
                'children' => [ //optional property that contains chaining rules
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
                'ruleName' => OwnPostRule::class,
                'children' => [
                    'updatePost' //updateOwnPost is part of updatePost action
                ],
            ],
            'deletePost' => [
                'description' => 'Delete any posts'
            ],
        ];
    }

}
```
NOTE! You might notice that **updatePost** action is part of **updateOwnPost** action. It means that if **updatePost** is not allowed the system will try to check the access to **updateOwnPost** as well. Because user might not have the access to update all posts, but he should be able to update his own posts.
This class implements next hierarchy: ![RBAC hierarchy](https://www.yiiframework.com/doc/guide/2.0/en/images/rbac-hierarchy-2.png)


5. Create specific rules for all actions you need. Your rules must implement **MatiosFree\LRbac\Contracts\IRbacRuleContract**:

This rule checks the user role:
```php
<?php
namespace App\Classes\Rules;


use MatiosFree\LRbac\Contracts\IRbacRuleContract;

class RoleRule implements IRbacRuleContract {

    public function execute($user, $item, $arguments): bool {
        return $user->role === $item->getName();
    }

}
```

This rule checks if the user is author of the post:
```php
<?php
namespace App\Classes\Rules;


use MatiosFree\LRbac\Contracts\IRbacRuleContract;

class OwnPostRule implements IRbacRuleContract {

    public function execute($user, $item, $arguments): bool {
        return $user->id === $arguments['post']->author_id;
    }

}
```

Usage
------------

In the code you can check the access totally same as described [in the official laravel documentation](https://laravel.com/docs/5.7/authorization#gates)

```php
if (Gate::allows('updatePost', ['post' => $post])) {
    // The current user can update the post...
}


if (Gate::denies('updatePost', ['post' => $post])) {
    // The current user can't update the post...
}


if (Gate::forUser($user)->allows('updatePost', ['post' => $post])) {
    // The user can update the post...
}

//In user model

if ($request->user()->can('updatePost', ['post' => $post])) {
    // The current user can update the post...
}

if ($request->user()->cannot('updatePost', ['post' => $post])) {
    // The current user can't update the post...
}

//In controller:

$this->authorize('updatePost', ['post' => $post]);

// In blade templates


@can('updatePost', ['post' => $post])
    <!-- // The current user can update the post... -->
@else
    <!-- The current user can't update the post... -->
@endcan

```

A default role is a role that is _implicitly_ assigned to _all_ users.
A default role is usually associated with a rule which determines if the role applies to the user being checked.


License
------------

The MIT License (MIT). Please see [License File](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/matiosfree/l-rbac.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/matiosfree/l-rbac.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/matiosfree/l-rbac
[link-downloads]: https://packagist.org/packages/matiosfree/l-rbac