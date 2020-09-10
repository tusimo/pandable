<?php


namespace Tusimo\Pandable\Queries;


use Tusimo\Pandable\Entities\QueryItem;
use Tusimo\Pandable\Entities\QueryOrderBy;
use Tusimo\Pandable\Entities\QueryPagination;
use Tusimo\Pandable\Entities\QuerySelect;
use Tusimo\Pandable\Entities\QueryWith;

trait QueryClientAble
{
    /**
     * @var QueryItem[]
     */
    protected $queryItems = [];

    /**
     * @var QueryOrderBy
     */
    protected $queryOrderBy;

    /**
     * @var QueryPagination
     */
    protected $queryPagination;

    /**
     * @var QuerySelect
     */
    protected $querySelect;

    /**
     * @var QueryWith
     */
    protected $queryWith;

    public function withQueryItem(QueryItem $queryItem)
    {
        $this->queryItems[$queryItem->getName()] = $queryItem;
        return $this;
    }

    public function setQueryOrderBy(QueryOrderBy $queryOrderBy)
    {
        $this->queryOrderBy = $queryOrderBy;
        return $this;
    }

    public function setQueryPagination(QueryPagination $queryPagination)
    {
        $this->queryPagination = $queryPagination;
        return $this;
    }

    public function setQuerySelect(QuerySelect $querySelect)
    {
        $this->querySelect = $querySelect;
        return $this;
    }

    public function setQueryWith(QueryWith $queryWith)
    {
        $this->queryWith = $queryWith;
        return $this;
    }
}