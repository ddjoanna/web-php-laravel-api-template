<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;

class ConditionsQueryBuilder
{
    private $page;
    private $pageSize;
    private $orderBy;
    private $orderDirection;
    private $columns;
    private $conditions = [];

    /**
     * 設定等於條件
     */
    public function where(string $column, $value): self
    {
        $this->conditions['where'][$column] = $value;
        return $this;
    }

    /**
     * 設定包含 (like) 條件
     */
    public function like(string $column, string $value): self
    {
        $this->conditions['like'][$column] = $value;
        return $this;
    }

    /**
     * 設定大於條件
     */
    public function greaterThan(string $column, $value): self
    {
        $this->conditions['range'][$column]['gt'] = $value;
        return $this;
    }

    /**
     * 設定大於等於條件
     */
    public function greaterThanOrEqual(string $column, $value): self
    {
        $this->conditions['range'][$column]['gte'] = $value;
        return $this;
    }

    /**
     * 設定小於條件
     */
    public function lessThan(string $column, $value): self
    {
        $this->conditions['range'][$column]['lt'] = $value;
        return $this;
    }

    /**
     * 設定小於等於條件
     */
    public function lessThanOrEqual(string $column, $value): self
    {
        $this->conditions['range'][$column]['lte'] = $value;
        return $this;
    }

    /**
     * 設定區間 (between) 條件
     */
    public function between(string $column, $start, $end): self
    {
        $this->conditions['range'][$column]['between'] = [$start, $end];
        return $this;
    }

    /**
     * 設定當前頁碼
     */
    public function setPage(int $page): self
    {
        $this->page = $page;
        return $this;
    }

    /**
     * 設定每頁顯示的數量
     */
    public function setPageSize(int $pageSize): self
    {
        $this->pageSize = $pageSize;
        return $this;
    }

    /**
     * 設定排序欄位
     */
    public function setOrderBy(string $orderBy): self
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    /**
     * 設定排序方向
     */
    public function setOrderDirection(string $orderDirection): self
    {
        $this->orderDirection = $orderDirection;
        return $this;
    }

    /**
     * 設定查詢欄位
     */
    public function setColumns(array $columns): self
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * 取得當前頁碼
     */
    public function getPage(): int
    {
        return $this->page ?? 1;
    }

    /**
     * 取得每頁顯示的數量
     */
    public function getPageSize(): int
    {
        return $this->pageSize ?? 10;
    }

    /**
     * 取得排序欄位
     */
    public function getOrderBy(): string
    {
        return $this->orderBy ?? 'id';
    }

    /**
     * 取得排序方向
     */
    public function getOrderDirection(): string
    {
        return $this->orderDirection ?? 'asc';
    }

    /**
     * 取得查詢欄位
     */
    public function getColumns(): array
    {
        return $this->columns ?? ['*'];
    }

    /**
     * 應用查詢條件
     */
    public function build(Builder $builder): Builder
    {
        if (!empty($this->conditions['where'])) {
            foreach ($this->conditions['where'] as $column => $value) {
                $builder->where($column, '=', $value);
            }
        }

        if (!empty($this->conditions['like'])) {
            foreach ($this->conditions['like'] as $column => $value) {
                $builder->where($column, 'like', '%' . $value . '%');
            }
        }

        if (!empty($this->conditions['range'])) {
            foreach ($this->conditions['range'] as $column => $range) {
                if (isset($range['gt'])) {
                    $builder->where($column, '>', $range['gt']);
                }
                if (isset($range['gte'])) {
                    $builder->where($column, '>=', $range['gte']);
                }
                if (isset($range['lt'])) {
                    $builder->where($column, '<', $range['lt']);
                }
                if (isset($range['lte'])) {
                    $builder->where($column, '<=', $range['lte']);
                }
                if (isset($range['between'])) {
                    [$start, $end] = $range['between'];
                    $builder->whereBetween($column, [$start, $end]);
                }
            }
        }

        if ($this->getColumns()) {
            $builder->select($this->getColumns());
        }

        if ($this->getOrderBy() && $this->getOrderDirection()) {
            $builder->orderBy($this->getOrderBy(), $this->getOrderDirection());
        }

        return $builder;
    }
}
