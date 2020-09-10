<?php

namespace Tusimo\Pandable\Entities\Traits;

use Tusimo\Pandable\Contracts\IdentifierContract;

trait IdentifierTrait
{
    /**
     * @var string $name 名称
     */
    protected $name;

    /**
     * @var string $identifier 唯一标识
     */
    protected $identifier;

    /**
     * IdentifierTrait constructor.
     * @param string $name
     * @param string $identifier
     */
    public function __construct(string $name, string $identifier)
    {
        $this->name = $name;
        $this->identifier = $identifier;
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    public function toArray()
    {
        return [
            'identifier' => $this->getIdentifier(),
            'name' => $this->getName(),
        ];
    }

    /**
     * 获取唯一标示
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * 获取名称
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function is(...$value): bool
    {
        foreach ($value as $item) {
            if ($item instanceof IdentifierContract) {
                return $this->getIdentifier() === $item->getIdentifier();
            }
            if (static::class === $item) {
                return true;
            }
            if ($item === $this->getIdentifier()) {
                return true;
            }
        }
        return false;
    }
}
