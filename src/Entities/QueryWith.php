<?php


namespace Tusimo\Pandable\Entities;

class QueryWith
{
    protected $with = [];

    /**
     * QueryWith constructor.
     * @param array $with
     */
    public function __construct(array $with = [])
    {
        $this->with = $with;
    }

    /**
     * @return array
     */
    public function getWith(): array
    {
        return $this->with;
    }

    /**
     * @param array $with
     */
    public function setWith(array $with): void
    {
        $this->with = $with;
    }
}
