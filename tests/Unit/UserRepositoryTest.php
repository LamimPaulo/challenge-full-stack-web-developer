<?php

namespace Tests\Unit;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = new UserRepository();
    }

    /** @test */
    public function it_can_paginate_users()
    {
        User::factory()->count(15)->create();

        $result = $this->userRepository->paginate(10);

        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $result);
        $this->assertCount(10, $result->items());
        $this->assertEquals(15, $result->total());
    }

    /** @test */
    public function it_can_find_a_user_by_uuid()
    {
        $uuid = Uuid::uuid4()->toString();
        $user = User::create([
            'id' => $uuid,
            'name' => 'josé',
            'email' => 'zé@mailinator.com',
        ]);

        $foundUser = $this->userRepository->findOrFail($uuid);

        $this->assertEquals($user->id, $foundUser->id);
    }

    /** @test */
    public function it_can_create_a_user()
    {
        $data = [
            'id' => Uuid::uuid4()->toString(),
            'name' => 'josé',
            'email' => 'zé@mailinator.com',
        ];

        $user = $this->userRepository->create($data);

        $this->assertDatabaseHas('users', $data);
        $this->assertEquals($data['name'], $user->name);
        $this->assertEquals($data['email'], $user->email);
    }

    /** @test */
    public function it_can_update_a_user()
    {
        $uuid = Uuid::uuid4()->toString();
        $user = User::create([
            'id' => $uuid,
            'name' => 'zé',
            'email' => 'ze@mailiantor.com',
        ]);

        $updateData = [
            'name' => 'paulo',
            'email' => 'paulo@mailinator.com',
        ];

        $updatedUser = $this->userRepository->update($user, $updateData);

        $this->assertEquals('paulo', $updatedUser->name);
        $this->assertEquals('paulo@mailinator.com', $updatedUser->email);
        $this->assertDatabaseHas('users', array_merge(['id' => $uuid], $updateData));
    }

    /** @test */
    public function it_can_delete_a_user()
    {
        $uuid = Uuid::uuid4()->toString();
        $user = User::create([
            'id' => $uuid,
            'name' => 'paul',
            'email' => 'paul@mailinator.com',
        ]);

        $result = $this->userRepository->delete($user);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('users', ['id' => $uuid]);
    }

    /** @test */
    public function it_throws_exception_when_user_not_found()
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $this->userRepository->findOrFail(Uuid::uuid4()->toString());
    }
}
