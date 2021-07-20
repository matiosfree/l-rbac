<?php

namespace MatiosFree\LRbac\Tests;

use Illuminate\Support\Facades\Gate;

class UnitTest extends TestCase {

    protected $user;
    protected $post;

    public function setUp(): void {
        parent::setUp();
        $this->user = (object)['role' => null];
        $this->post = (object)[];
    }

    /** @test */
    public function testUserWithoutRole() {
        $this->assertFalse(Gate::forUser($this->user)->allows('deletePost'));
    }

    /** @test */
    public function testUserWithWrongRole() {
        $this->user->role = 'wrong-role';
        $this->assertFalse(Gate::forUser($this->user)->allows('deletePost'));
    }

    /** @test */
    public function testUserCanDeletePostByRole() {
        $this->user->role = 'manager';
        $this->assertTrue(Gate::forUser($this->user)->allows('deletePost'));
    }

    /** @test */
    public function testUserCannotAccessExtraAction() {
        $this->user->role = 'manager';
        $this->assertFalse(Gate::forUser($this->user)->allows('dummy_permission'));
    }

    /** @test */
    public function testUserCanUpdateOwnPostByRole() {
        $this->user->role = 'manager';
        $this->user->id = 1;
        $this->post->user_id = 1;

        $this->assertTrue(Gate::forUser($this->user)->allows('updatePost', ['post' => $this->post]));
    }

    /** @test */
    public function testUserCanUpdatePostByRole() {
        $this->user->role = 'manager';
        $this->user->id = 1;
        $this->post->user_id = 2;

        $this->assertTrue(Gate::forUser($this->user)->allows('updatePost', ['post' => $this->post]));
    }

    /** @test */
    public function testUserCanUpdateOwnPostByRule() {
        $this->user->role = 'user';
        $this->user->id = 1;
        $this->post->user_id = 1;

        $this->assertTrue(Gate::forUser($this->user)->allows('updatePost', ['post' => $this->post]));
    }

    /** @test */
    public function testUserCanNotUpdatePost() {
        $this->user->role = 'user';
        $this->user->id = 1;
        $this->post->user_id = 2;

        $this->assertFalse(Gate::forUser($this->user)->allows('updatePost', ['post' => $this->post]));
    }

}