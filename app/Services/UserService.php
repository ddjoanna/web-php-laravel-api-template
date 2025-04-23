<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\ValueObjects\UserValueObject;
use App\Entities\User as UserEntity;

class UserService
{
    protected UserRepository $UserRepository;

    public function __construct(UserRepository $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }

    public function create(UserValueObject $UserVO): UserEntity
    {
        return $this->UserRepository->create($UserVO);
    }

    public function find(int $id, bool $withToken = false, bool $withPassword = false): ?UserEntity
    {
        return $this->UserRepository->find($id, $withToken, $withPassword);
    }

    public function findByEmail(string $email, bool $withToken = false, bool $withPassword = false): ?UserEntity
    {
        return $this->UserRepository->findByEmail($email, $withToken, $withPassword);
    }

    public function logout(string $token): bool
    {
        return $this->UserRepository->logout($token);
    }
}
