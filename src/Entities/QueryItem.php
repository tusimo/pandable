<?php


namespace Tusimo\Pandable\Entities;

use Illuminate\Contracts\Support\Arrayable;

class QueryItem implements Arrayable
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $operation = '=';
    /**
     * @var mixed
     */
    protected $value;

    /**
     * QueryItem constructor.
     * @param string $name
     * @param string $operation
     * @param mixed $value
     */
    public function __construct(string $name, string $operation, $value)
    {
        $this->name = $name;
        $this->operation = $operation;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getOperation(): string
    {
        return $this->operation;
    }

    /**
     * @param string $operation
     */
    public function setOperation(string $operation): void
    {
        $this->operation = $operation;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'operation' => $this->operation,
            'value' => $this->value,
        ];
    }
}
