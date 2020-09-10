<?php


namespace Tusimo\Pandable\Contracts;

use Tusimo\Pandable\Entities\QueryOrderBy;
use Tusimo\Pandable\Entities\QueryPagination;
use Tusimo\Pandable\Entities\QuerySelect;
use Tusimo\Pandable\Entities\QueryWith;

interface QueryServerContract
{
    /**
     * get query items
     * @return array
     */
    public function getQueryItems(): array;

    /**
     * get query order by
     * @return QueryOrderBy|null
     */
    public function getQueryOrderBy(): ?QueryOrderBy;

    /**
     * get query pagination
     * @return QueryPagination|null
     */
    public function getQueryPagination(): ?QueryPagination;

    /**
     * get query select
     * @return QuerySelect|null
     */
    public function getQuerySelect(): ?QuerySelect;

    /**
     * get query with
     * @return QueryWith|null
     */
    public function getQueryWith(): ?QueryWith;
}
