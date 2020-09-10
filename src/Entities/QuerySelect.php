<?php


namespace Tusimo\Pandable\Entities;

class QuerySelect
{
    /**
     * select resource keys ,empty is all
     * @var array
     */
    protected $selects = [];

    /**
     * QuerySelect constructor.
     * @param array $selects
     */
    public function __construct(array $selects)
    {
        $this->selects = $selects;
    }

    /**
     * @return array
     */
    public function getSelects(): array
    {
        return $this->selects;
    }

    /**
     * @param array $selects
     */
    public function setSelects(array $selects): void
    {
        $this->selects = $selects;
    }
}
