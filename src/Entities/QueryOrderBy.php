<?php


namespace Tusimo\Pandable\Entities;

class QueryOrderBy
{
    protected $orderBy = 'id';

    protected $orderByDirection = 'desc';

    /**
     * QueryOrderBy constructor.
     * @param string $orderBy
     * @param string $orderByDirection
     */
    public function __construct(string $orderBy = 'id', string $orderByDirection = 'desc')
    {
        $this->orderBy = $orderBy;
        $this->orderByDirection = $orderByDirection;
    }

    /**
     * @return string
     */
    public function getOrderBy(): string
    {
        return $this->orderBy;
    }

    /**
     * @param string $orderBy
     */
    public function setOrderBy(string $orderBy): void
    {
        $this->orderBy = $orderBy;
    }

    /**
     * @return string
     */
    public function getOrderByDirection(): string
    {
        return $this->orderByDirection;
    }

    /**
     * @param string $orderByDirection
     */
    public function setOrderByDirection(string $orderByDirection): void
    {
        $this->orderByDirection = $orderByDirection;
    }
}
