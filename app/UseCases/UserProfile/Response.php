<?php

namespace App\UseCases\UserProfile;

use App\Entities\User;

class Response
{
    protected ?array $user = null;

    public function setUser(User $user): void
    {
        $this->user = [
            'id' => $user->getId(),
            'name' => $user->getProps()->getName(),
            'email' => $user->getProps()->getEmail(),

        ];
    }

    public function toArray(): ?array
    {
        return $this->user;
    }
}
