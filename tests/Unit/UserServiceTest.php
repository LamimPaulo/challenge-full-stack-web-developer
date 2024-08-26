<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\UserService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Ramsey\Uuid\Uuid;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = app(UserService::class);
    }

    /** @test */
    public function it_can_list_users()
    {
        User::factory()->count(3)->create();

        $users = $this->userService->listUsers();

        $this->assertCount(3, $users->items());
    }

    /** @test */
    public function it_can_create_a_user()
    {
        $uuid = (string) Uuid::uuid4();
        $userData = [
            'id' => $uuid,
            'name' => 'Zé',
            'email' => 'ze@mailinator.com',
        ];

        $user = $this->userService->createUser($userData);

        $this->assertDatabaseHas('users', $userData);
    }

    /** @test */
    public function it_can_update_a_user()
    {
        $user = User::create([
            'id' => Uuid::uuid4(),
            'name' => 'Zé',
            'email' => 'ze@mailinator.com',
        ]);

        $updateData = [
            'name' => 'João',
            'email' => 'joao@mailinator.com',
        ];

        $updatedUser = $this->userService->updateUser($user->id, $updateData);

        $this->assertDatabaseHas('users', array_merge(['id' => $user->id], $updateData));
    }

    /** @test */
    public function it_can_delete_a_user()
    {
        $user = User::create([
            'id' => Uuid::uuid4(),
            'name' => 'Zé',
            'email' => 'ze@mailinator.com',
        ]);

        $deletedUser = $this->userService->deleteUser($user->id);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test */
    public function it_throws_exception_when_user_not_found()
    {
        $this->expectException(ModelNotFoundException::class);

        $this->userService->getUserById(Uuid::uuid4());
    }
}
