<?php

namespace App\Entities;

use Illuminate\Support\Facades\Hash;

class User
{
    private int $id;
    private Props\UserProps $props;
    private ?string $api_token;
    private ?string $password_hash;

    public function __construct(int $id, Props\UserProps $props)
    {
        $this->id = $id;
        $this->props = $props;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProps(): Props\UserProps
    {
        return $this->props;
    }

    public function setProps(Props\UserProps $props): void
    {
        $this->props = $props;
    }

    public function setApiToken(string $api_token): void
    {
        $this->api_token = $api_token;
    }

    public function getApiToken(): ?string
    {
        return $this->api_token;
    }

    public function setPasswordHash(string $password_hash): void
    {
        $this->password_hash = $password_hash;
    }

    public function getPasswordHash(): ?string
    {
        return $this->password_hash;
    }

    public function validatePassword(string $password): bool
    {
        $password_hash = $this->getPasswordHash();
        if (!Hash::check($password, $password_hash)) {
            return false;
        }
        return true;
    }
}
