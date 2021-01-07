<?php


namespace Tusimo\Pandable\Queries;

use Illuminate\Support\Str;
use Tusimo\Pandable\Contracts\QueryServerContract;
use Tusimo\Pandable\Entities\QueryItem;
use Tusimo\Pandable\Entities\QueryOrderBy;
use Tusimo\Pandable\Entities\QueryPagination;
use Tusimo\Pandable\Entities\QuerySelect;
use Tusimo\Pandable\Entities\QueryWith;

class RequestServerQuery extends Request implements QueryServerContract
{
    public function getQueryItems(): array
    {
        $queryItems = [];
        $queries = $this->get('query', []);
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
        if (!$this->has('order_by')) {
            return null;
        }
        return new QueryOrderBy(
            $this->get('order_by', 'id'),
            $this->get('order', 'desc')
        );
    }

    public function getQueryPagination(): ?QueryPagination
    {
        if (!$this->has('page')) {
            return null;
        }
        return new QueryPagination($this->get('page', 0), $this->get('per_page', 10));
    }

    public function getQuerySelect(): ?QuerySelect
    {
        if (!$this->has('select')) {
            return null;
        }
        $select = $this->get('select');
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
        if (!$this->has('with')) {
            return null;
        }
        $with = $this->get('with');
        if ($with) {
            return new QueryWith($this->getArray($with));
        }
        return null;
    }
}
