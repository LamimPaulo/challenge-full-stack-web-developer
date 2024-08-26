<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function index()
    {
        $users = $this->userService->listUsers();
        return $this->successResponse('Success', $users);
    }

    public function show($id)
    {
        $user = $this->userService->getUserById($id);
        return $this->successResponse('Usuário Encontrado', $user);
    }

    /**
     * Store a newly created user in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUserRequest $request)
    {   
        $user = $this->userService->createUser([
                'id' => $request->uuid,
                'name' => $request->name,
                'email' => $request->email,
            ]);

        return $this->successResponse('Usuário criado com sucesso', $user, Response::HTTP_CREATED);
    }

    /**
     * Update the specified user in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $user = $this->userService->updateUser($id, $request->all());

            return $this->successResponse('Usuário atualizado com sucesso!', $user);

        } catch (ModelNotFoundException $e) {
            return $this->errorResponse('Usuário não encontrado.', Response::HTTP_NOT_FOUND);
        }
    }
    public function delete($id)
    {
        try {
            $user = $this->userService->deleteUser($id);

            return $this->successResponse('Usuário excluido com sucesso!', $user);

        } catch (ModelNotFoundException $e) {
            return $this->errorResponse('Usuário não encontrado.', Response::HTTP_NOT_FOUND);
        }
    }
}
