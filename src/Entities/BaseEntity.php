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
     * the other properties that passed
     * @var array
     */
    protected $trashed;

    /**
     * Create a new fluent instance.
     *
     * @param array|object $attributes
     * @return void
     */
    public function __construct($attributes = [])
    {
        $this->trashed = [];
        foreach ($attributes as $key => $value) {
            if ($this->isAttributeDefined($key)) {
                $this->attributes[$key] = $value;
            } else {
                $this->trashed[$key] = $value;
            }
        }
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

    public function getId(): int
    {
        return (int)$this->id;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function setId(int $id)
    {
        $this->id = $id;
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

    /**
     * get trashed items
     * @return array
     */
    public function getTrashed(): array
    {
        return $this->trashed;
    }

    /**
     * determine property is trashed or not
     */
    public function isTrashed(string $key): bool
    {
        return isset($this->trashed[$key]);
    }

    /**
     * move property to trash
     * @param string $key
     * @return $this
     */
    public function trash(string $key)
    {
        if ($this->offsetExists($key)) {
            $this->trashed[$key] = $this->pop($key);
        }
        return $this;
    }

    /**
     * return property and remove it
     * @param $key
     * @return mixed
     */
    public function pop($key)
    {
        $result = $this->get($key);
        $this->offsetUnset($key);
        return $result;
    }

    /**
     * @param  $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if ($this->isAttributeDefined($key)) {
            return parent::get($key, $default);
        }
    }

    /**
     * restore trashed property
     * @param $key
     * @return $this
     */
    public function restore($key)
    {
        if (isset($this->trashed[$key])) {
            $this->offsetSet($key, $this->trashed[$key]);
            unset($this->trashed[$key]);
        }
        return $this;
    }

    /**
     * Set the value at the given offset.
     *
     * @param string $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if ($this->isAttributeDefined($offset)) {
            parent::offsetSet($offset, $value);
        }
    }
}
