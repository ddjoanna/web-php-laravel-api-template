<?php

namespace App\UseCases\UserLogin;

use App\Entities\User;

class Response
{
    protected ?array $user = null;
    protected ?string $token = null;

    public function setUser(User $user): void
    {
        $this->user = [
            'id' => $user->getId(),
            'name' => $user->getProps()->getName(),
            'email' => $user->getProps()->getEmail(),

        ];
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function toArray(): array
    {
        return [
            'user' => $this->user,
            'token' => $this->token,
        ];
    }
}
