<?php


namespace Tusimo\Pandable\Queries;

use Illuminate\Support\Arr;
use Tusimo\Pandable\Contracts\UriQueryClientContract;
use Tusimo\Pandable\Entities\QueryItem;
use Tusimo\Pandable\Entities\QueryOrderBy;
use Tusimo\Pandable\Entities\QueryPagination;
use Tusimo\Pandable\Entities\QuerySelect;
use Tusimo\Pandable\Entities\QueryWith;

class RequestClientQuery implements UriQueryClientContract
{
    use QueryClientAble;

    const OPERATIONS = [
        '=',
        '>',
        '<',
        'in',
        'between'
    ];

    /**
     * @param string $key
     * @param $operation
     * @param null $value
     * @return $this
     */
    public function where(string $key, $operation, $value = null)
    {
        if ($value === null) {
            $this->withQueryItem(new QueryItem($key, '=', $operation));
            return $this;
        }
        if (!in_array($operation, static::OPERATIONS)) {
            $this->where($key, '=', $value);
            return $this;
        }
        $this->withQueryItem(new QueryItem($key, $operation, $value));
        return $this;
    }

    /**
     * @param string $key
     * @param mixed ...$value
     * @return $this
     */
    public function whereIn(string $key, ...$value)
    {
        $values = Arr::flatten($value);
        $this->withQueryItem(new QueryItem($key, 'in', $values));
        return $this;
    }

    /**
     * @param string $key
     * @param array $value
     * @return $this
     */
    public function whereBetween(string $key, array $value)
    {
        $this->withQueryItem(new QueryItem($key, 'between', $value));
        return $this;
    }

    /**
     * @param string $key
     * @param string $direction
     * @return $this
     */
    public function orderBy(string $key, string $direction = 'desc')
    {
        $this->setQueryOrderBy(new QueryOrderBy($key, $direction));
        return $this;
    }

    /**
     * @param array $select
     * @return $this
     */
    public function select(array $select)
    {
        $this->setQuerySelect(new QuerySelect($select));
        return $this;
    }

    /**
     * @param mixed ...$with
     * @return $this
     */
    public function with(...$with)
    {
        $with = Arr::flatten($with);
        $this->setQueryWith(new QueryWith($with));
        return $this;
    }

    /**
     * @param int $perPage
     * @param int $page
     * @return $this
     */
    public function page(int $perPage, int $page = 10)
    {
        $this->setQueryPagination(new QueryPagination($page, $perPage));
        return $this;
    }

    /**
     * @return string
     */
    public function toUriQueryString(): string
    {
        $queries = [];
        if ($this->queryItems) {
            $queries['query'] = [];
            foreach ($this->queryItems as $queryItem) {
                $queries['query'][$queryItem->getName()] = $this->parseQueryItem($queryItem);
            }
        }
        if ($this->queryWith) {
            $with = $this->queryWith->getWith();
            if (!empty($with)) {
                $queries['with'] = implode(",", $with);
            }
        }
        if ($this->querySelect) {
            $select = $this->querySelect->getSelects();
            if (!empty($select)) {
                $queries['select'] = implode(",", $select);
            }
        }
        if ($this->queryOrderBy) {
            $queries['order_by'] = $this->queryOrderBy->getOrderBy();
            $queries['order'] = $this->queryOrderBy->getOrderByDirection();
        }
        if ($this->queryPagination) {
            $queries['page'] = $this->queryPagination->getPage();
            $queries['per_page'] = $this->queryPagination->getPerPage();
        }
        return http_build_query($queries);
    }

    /**
     * @param QueryItem $queryItem
     * @return string
     */
    protected function parseQueryItem(QueryItem $queryItem): string
    {
        if ($queryItem->getOperation() === '>') {
            return $queryItem->getValue() . '~';
        }
        if ($queryItem->getOperation() === '<') {
            return '~' . $queryItem->getValue();
        }
        if ($queryItem->getOperation() === 'in') {
            return implode(',', $queryItem->getValue());
        }
        if ($queryItem->getOperation() === 'between') {
            list($first, $second) = $queryItem->getValue();
            return $first . '~' . $second;
        }
        return $queryItem->getValue();
    }
}