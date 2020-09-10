<?php


namespace Tusimo\Pandable\Entities;

class QueryPagination
{
    protected $page = 0;

    protected $perPage = 10;


    /**
     * QueryPagination constructor.
     * @param int $page
     * @param int $perPage
     */
    public function __construct(int $page = 0, int $perPage = 10)
    {
        $this->page = $page;
        $this->perPage = $perPage;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param int $page
     */
    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * @param int $perPage
     */
    public function setPerPage(int $perPage): void
    {
        $this->perPage = $perPage;
    }
}
