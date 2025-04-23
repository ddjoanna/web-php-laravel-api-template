<?php

namespace App\Repositories;

use App\Models\User;
use App\Entities\User as UserEntity;
use App\ValueObjects\UserValueObject;
use App\Factories\UserFactory;
use App\Models\PersonalAccessToken;

class UserRepository
{
    public function create(UserValueObject $userVO): UserEntity
    {
        $user = User::create($userVO->getUser());
        $token = $user->createToken('api')->plainTextToken;
        $entity = UserFactory::create($user->toArray());
        $entity->setApiToken($token);
        return $entity;
    }

    public function find(int $id, bool $withToken = false, bool $withPassword = false): ?UserEntity
    {
        $user = User::find($id);
        if ($user === null) {
            return null;
        }
        $entity = UserFactory::create($user->toArray());
        if ($withToken) {
            $token = $user->createToken('api')->plainTextToken;
            $entity->setApiToken($token);
        }
        if ($withPassword) {
            $entity->setPasswordHash($user->password);
        }
        return $entity;
    }

    public function findByEmail(string $email, bool $withToken = false, bool $withPassword = false): ?UserEntity
    {
        $user = User::where('email', $email)->first();
        if ($user === null) {
            return null;
        }
        $entity = UserFactory::create($user->toArray());
        if ($withToken) {
            $token = $user->createToken('api')->plainTextToken;
            $entity->setApiToken($token);
        }
        if ($withPassword) {
            $entity->setPasswordHash($user->password);
        }
        return $entity;
    }

    public function logout(string $token): bool
    {
        return PersonalAccessToken::where('token', $token)->delete();
    }
}
