<?php


namespace Tusimo\Pandable\Contracts;

use Tusimo\Pandable\Entities\QueryItem;
use Tusimo\Pandable\Entities\QueryOrderBy;
use Tusimo\Pandable\Entities\QueryPagination;
use Tusimo\Pandable\Entities\QuerySelect;
use Tusimo\Pandable\Entities\QueryWith;

interface QueryClientContract
{
    /**
     * add a query item
     * @param QueryItem $queryItem
     * @return static
     */
    public function withQueryItem(QueryItem $queryItem);

    /**
     * set query order by
     * @param QueryOrderBy $queryOrderBy
     * @return static
     */
    public function setQueryOrderBy(QueryOrderBy $queryOrderBy);

    /**
     * set query pagination
     * @param QueryPagination $queryPagination
     * @return static
     */
    public function setQueryPagination(QueryPagination $queryPagination);

    /**
     * set query select
     * @param QuerySelect $querySelect
     * @return static
     */
    public function setQuerySelect(QuerySelect $querySelect);

    /**
     * set query with
     * @param QueryWith $queryWith
     * @return mixed
     */
    public function setQueryWith(QueryWith $queryWith);
}
