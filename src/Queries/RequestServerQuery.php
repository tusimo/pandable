<?php


namespace Tusimo\Pandable\Queries;

use Illuminate\Support\Str;
use Tusimo\Pandable\Contracts\QueryServerContract;
use Tusimo\Pandable\Entities\QueryItem;
use Tusimo\Pandable\Entities\QueryOrderBy;
use Tusimo\Pandable\Entities\QueryPagination;
use Tusimo\Pandable\Entities\QuerySelect;
use Tusimo\Pandable\Entities\QueryWith;

class RequestServerQuery implements QueryServerContract
{
    /**
     * @var array
     */
    protected $parameters = [];

    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function getQueryItems(): array
    {
        $queryItems = [];
        $queries = $this->parameters['query'] ?? [];
        foreach ($queries as $key => $query) {
            $queryItems[$key] = $this->parseQueryItem($key, $query);
        }
        return $queryItems;
    }

    /**
     * = 12
     * = 10~12 | ~13 | 14~
     * = 1,2,3
     * only support equal and range query
     * @param string $key
     * @param string $queryString
     * @return QueryItem
     */
    protected function parseQueryItem(string $key, string $queryString): QueryItem
    {
        if (Str::contains($queryString, '~')) {
            list($first, $second) = explode('~', $queryString);
            if ($first && $second) {
                return new QueryItem($key, 'between', [$first, $second]);
            }
            if ($first) {
                return new QueryItem($key, '>', $first);
            }
            if ($second) {
                return new QueryItem($key, '<', $second);
            }
        }
        if (Str::contains($queryString, ',')) {
            return new QueryItem($key, 'in', explode(',', $queryString));
        }
        return new QueryItem($key, '=', $queryString);
    }

    public function getQueryOrderBy(): ?QueryOrderBy
    {
        if (!isset($this->parameters['order_by'])) {
            return null;
        }
        return new QueryOrderBy(
            $this->parameters['order_by'] ?? 'id',
            $this->parameters['order'] ?? 'desc'
        );
    }

    public function getQueryPagination(): ?QueryPagination
    {
        if (!isset($this->parameters['page'])) {
            return null;
        }
        return new QueryPagination($this->parameters['page'] ?? 1, $this->parameters['per_page'] ?? 10);
    }

    public function getQuerySelect(): ?QuerySelect
    {
        if (!isset($this->parameters['select'])) {
            return null;
        }
        $select = $this->parameters['select'];
        if ($select) {
            return new QuerySelect($this->getArray($select));
        }
        return null;
    }

    /**
     * 根据字符获取
     * @param string|array $item
     * @return array
     */
    protected function getArray($item): array
    {
        if (is_array($item)) {
            return $item;
        }
        if (is_string($item)) {
            return explode(',', $item);
        }
        return [];
    }

    public function getQueryWith(): ?QueryWith
    {
        if (!isset($this->parameters['with'])) {
            return null;
        }
        $with = $this->parameters['with'];
        if ($with) {
            return new QueryWith($this->getArray($with));
        }
        return null;
    }
}
