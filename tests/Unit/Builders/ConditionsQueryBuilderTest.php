<?php

namespace Tests\Unit\Builders;

use App\Builders\ConditionsQueryBuilder;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ConditionsQueryBuilderTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * 測試等於條件
     */
    public function testWhereCondition()
    {
        $builder = new ConditionsQueryBuilder();
        $builder->where('name', 'John');

        $queryBuilder = $builder->build(User::query());

        $this->assertStringContainsString('select * from `users` where `name` = ? order by `id` asc', $queryBuilder->toSql());
        $this->assertEquals(['John'], $queryBuilder->getBindings());
    }

    /**
     * 測試包含 (like) 條件
     */
    public function testLikeCondition()
    {
        $builder = new ConditionsQueryBuilder();
        $builder->like('name', 'John');

        $queryBuilder = $builder->build(User::query());

        $this->assertStringContainsString('select * from `users` where `name` like ? order by `id` asc', $queryBuilder->toSql());
        $this->assertEquals(['%John%'], $queryBuilder->getBindings());
    }

    /**
     * 測試大於條件
     */
    public function testGreaterThanCondition()
    {
        $builder = new ConditionsQueryBuilder();
        $builder->greaterThan('age', 18);

        $queryBuilder = $builder->build(User::query());

        $this->assertStringContainsString('select * from `users` where `age` > ? order by `id` asc', $queryBuilder->toSql());
        $this->assertEquals([18], $queryBuilder->getBindings());
    }

    /**
     * 測試大於等於條件
     */
    public function testGreaterThanOrEqualCondition()
    {
        $builder = new ConditionsQueryBuilder();
        $builder->greaterThanOrEqual('age', 18);

        $queryBuilder = $builder->build(User::query());

        $this->assertStringContainsString('select * from `users` where `age` >= ? order by `id` asc', $queryBuilder->toSql());
        $this->assertEquals([18], $queryBuilder->getBindings());
    }

    /**
     * 測試小於條件
     */
    public function testLessThanCondition()
    {
        $builder = new ConditionsQueryBuilder();
        $builder->lessThan('age', 18);

        $queryBuilder = $builder->build(User::query());

        $this->assertStringContainsString('select * from `users` where `age` < ? order by `id` asc', $queryBuilder->toSql());
        $this->assertEquals([18], $queryBuilder->getBindings());
    }

    /**
     * 測試小於等於條件
     */
    public function testLessThanOrEqualCondition()
    {
        $builder = new ConditionsQueryBuilder();
        $builder->lessThanOrEqual('age', 18);

        $queryBuilder = $builder->build(User::query());

        $this->assertStringContainsString('select * from `users` where `age` <= ? order by `id` asc', $queryBuilder->toSql());
        $this->assertEquals([18], $queryBuilder->getBindings());
    }

    /**
     * 測試區間 (between) 條件
     */
    public function testBetweenCondition()
    {
        $builder = new ConditionsQueryBuilder();
        $builder->between('age', 18, 25);

        $queryBuilder = $builder->build(User::query());

        [$start, $end] = [18, 25];
        // Assert SQL contains between clause
        $this->assertStringContainsString('select * from `users` where `age` between ? and ? order by `id` asc', $queryBuilder->toSql());
        // Assert bindings are correct
        $this->assertEquals([$start, $end], $queryBuilder->getBindings());
    }

    /**
     * 測試排序
     */
    public function testOrderBy()
    {
        $builder = new ConditionsQueryBuilder();
        // Set sorting conditions
        $builder->setOrderBy('name');
        $builder->setOrderDirection('desc');

        // Build query using Eloquent model
        $queryBuilder = $builder->build(User::query());

        // Assert SQL contains order by clause
        $this->assertStringContainsString('select * from `users` order by `name` desc', $queryBuilder->toSql());
    }

    /**
     * 測試查詢欄位
     */
    public function testSelectColumns()
    {
        // Set columns to select
        $builder = new ConditionsQueryBuilder();
        $builder->setColumns(['name', 'email']);

        // Build query using Eloquent model
        $queryBuilder = $builder->build(User::query());

        // Assert SQL contains select columns
        $this->assertStringContainsString('select `name`, `email` from `users` order by `id` asc', $queryBuilder->toSql());
    }

    /**
     * 測試分頁
     */
    public function testPagination()
    {
        $builder = new ConditionsQueryBuilder();
        $builder->setPage(1);
        $builder->setPageSize(10);

        // Note: Eloquent does not directly support pagination in the query builder.
        //       You would typically use paginate() on the query result.
        //       Here we just verify that the page and size are set correctly.
        $this->assertEquals(1, $builder->getPage());
        $this->assertEquals(10, $builder->getPageSize());
    }
}
