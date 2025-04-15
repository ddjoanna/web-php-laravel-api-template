<?php

namespace App\UseCases\RegisterUser;

class Response
{
    protected array $user = [];

    public function setUser(array $user): void
    {
        $this->user = $user;
    }

    public function toArray(): array
    {
        return $this->user;
    }
}
