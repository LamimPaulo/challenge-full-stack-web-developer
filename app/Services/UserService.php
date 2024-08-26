<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function listUsers()
    {
        return $this->userRepository->paginate(10);
    }

    public function getUserById($id)
    {
        return $this->userRepository->findOrFail($id);
    }

    public function createUser(array $data)
    {
        return $this->userRepository->create($data);
    }

    public function updateUser($id, array $data)
    {
        $user = $this->userRepository->findOrFail($id);
        return $this->userRepository->update($user, $data);
    }

    public function deleteUser($id)
    {
        $user = $this->userRepository->findOrFail($id);
        $this->userRepository->delete($user);
        return $user;
    }
}
