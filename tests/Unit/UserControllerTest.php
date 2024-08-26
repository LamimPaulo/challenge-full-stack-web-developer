<?php

namespace Tests\Unit;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\App;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_users()
    {
        User::factory()->count(3)->create();

        $controller = App::make(UserController::class);
        $response = $controller->index();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->status());
        $this->assertArrayHasKey('data', $response->getData(true));
        $this->assertCount(3, $response->getData(true)['data']['data']);
    }

    /** @test */
    public function it_can_store_a_new_user()
    {
        $uuid = (string) Uuid::uuid4();
        $userData = [
            'uuid' => $uuid,
            'name' => 'Zé',
            'email' => 'zé@mailinator.com',
        ];

        $controller = App::make(UserController::class);
        $request = new StoreUserRequest($userData);
        $response = $controller->store($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_CREATED, $response->status());
        $this->assertDatabaseHas('users', [
            'id' => $userData['uuid'],
            'name' => $userData['name'],
            'email' => $userData['email'],
        ]);
        $this->assertJson($response->getContent());
    }

    /** @test */
    public function it_can_update_an_existing_user()
    {
        $user = User::create([
            'id' => Uuid::uuid4(),
            'name' => 'ze',
            'email' => 'ze@mailinator.com',
        ]);

        $updateData = [
            'name' => 'João',
            'email' => 'joão@mailinator.com',
        ];

        $controller = App::make(UserController::class);
        $request = new UpdateUserRequest($updateData);
        $response = $controller->update($request, $user->id);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->status());
        $this->assertDatabaseHas('users', array_merge(['id' => $user->id], $updateData));
    }

    /** @test */
    public function it_can_delete_a_user()
    {
        $user = User::create([
            'id' => 'delete-uuid',
            'name' => 'Zé',
            'email' => 'ze@mailinator.com',
        ]);

        $controller = App::make(UserController::class);
        $response = $controller->delete($user->id);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->status());
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
