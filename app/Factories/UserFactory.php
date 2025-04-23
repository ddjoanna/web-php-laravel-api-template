<?php

namespace App\Factories;

use App\Entities\Props\UserProps;
use App\Entities\User as UserEntity;

class UserFactory
{
    public static function create(array $row): UserEntity
    {
        return new UserEntity(
            $row['id'],
            new UserProps(
                $row['name'],
                $row['email'],
            )
        );
    }

    public static function bulk(array $rows): array
    {
        return array_map(function ($row) {
            return self::create($row);
        }, $rows);
    }
}
