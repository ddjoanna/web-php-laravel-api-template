<?php

namespace App\ValueObjects;

use Illuminate\Support\Facades\Hash;

final class UserValueObject
{
    private string $name;
    private string $email;
    private string $password;

    public function __construct(
        string $name,
        string $email,
        string $password
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPasswordHash(): string
    {
        return Hash::make($this->password);
    }

    public function getUser(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->getPasswordHash(),
        ];
    }
}
