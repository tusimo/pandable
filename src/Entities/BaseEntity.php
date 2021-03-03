<?php


namespace Tusimo\Pandable\Entities;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Fluent;
use Tusimo\Pandable\Contracts\Entities\BaseEntityContract;
use Tusimo\Pandable\Entities\Traits\EntityTrait;

/**
 * @property mixed id
 * @property mixed created_at
 * @property mixed updated_at
 */
abstract class BaseEntity extends Fluent implements BaseEntityContract
{
    use EntityTrait;

    /**
     * Create a new fluent instance.
     *
     * @param array|object $attributes
     * @return void
     */
    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->init();
    }

    /**
     * 根据规则创建一个新的实体
     * @param $attributes
     * @return static
     */
    public static function createEntity($attributes)
    {
        return new static($attributes);
    }

    public function getId()
    {
        return $this->{$this->resourceKey()};
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function setId($id)
    {
        $this->{$this->resourceKey()} = $id;
        return $this;
    }

    public function setCreatedAt($value)
    {
        $this->created_at = $value;
    }

    public function setUpdatedAt($value)
    {
        $this->updated_at = $value;
    }

    public function toArray()
    {
        $array = [];
        foreach ($this->attributes as $key => $value) {
            if ($value instanceof Arrayable) {
                $array[$key] = $value->toArray();
            } else {
                $array[$key] = $value;
            }
        }
        return $array;
    }
}
