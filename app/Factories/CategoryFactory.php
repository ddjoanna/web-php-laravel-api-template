<?php

namespace App\Factories;

use App\Entities\Props\CategoryProps;
use App\Entities\Category as CategoryEntity;

class CategoryFactory
{
    public static function create(array $row): CategoryEntity
    {
        $entity = new CategoryEntity(
            $row['id'],
            new CategoryProps(
                $row['name'],
                $row['parent_id'],
                $row['layer'],
                $row['sort_order'],
                $row['is_active']
            )
        );

        if (!empty($row['children'])) {
            $entity->setChildren(CategoryFactory::bulk($row['children']));
        }

        return $entity;
    }

    public static function bulk(array $rows): array
    {
        return array_map(function ($row) {
            return self::create($row);
        }, $rows);
    }
}
