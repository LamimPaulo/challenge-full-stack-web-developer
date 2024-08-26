<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);

        return $this->successResponse('Success', $users);
    }

    public function show($id)
    {
        $user = User::find($id);
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
        $user = User::create([
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
            $user = User::findOrFail($id);
            $user->update($request->all());

            return $this->successResponse('Usuário atualizado com sucesso!', $user);

        } catch (ModelNotFoundException $e) {
            return $this->errorResponse('Usuário não encontrado.', Response::HTTP_NOT_FOUND);
        }
    }
    public function delete($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return $this->successResponse('Usuário excluido com sucesso!', $user);

        } catch (ModelNotFoundException $e) {
            return $this->errorResponse('Usuário não encontrado.', Response::HTTP_NOT_FOUND);
        }
    }
}
