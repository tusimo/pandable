<?php


namespace Tusimo\Pandable\Entities\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Tusimo\Pandable\Contracts\Entities\BaseEntityContract;

trait EntityTrait
{
    /**
     * determine is entity or not
     * @param $value
     * @return bool
     */
    public function isEntity($value): bool
    {
        return $this instanceof $value;
    }

    /**
     * covert to an spec entity
     * @param $target
     * @return BaseEntityContract
     */
    public function covertTo($target)
    {
        return (new $target($this->toArray()))->init();
    }

    /**
     * is an attribute is defined or not
     * @param $key
     * @return bool
     */
    public function isAttributeDefined($key)
    {
        return array_key_exists($key, $this->propertyRules);
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

    /**
     * get entity update rules
     * @param null $key
     * @return array|string
     */
    public function getUpdatedRules($key = null)
    {
        if ($key) {
            return $this->covertUpdatedRule($key, $this->getCreateRules($key));
        }
        $updatedRules = [];
        foreach ($this->getCreateRules() as $k => $rules) {
            $updatedRules[$k] = $this->covertUpdatedRule($k, $rules);
        }
        return $updatedRules;
    }

    /**
     * delete required rules
     * @param $key
     * @param $rules
     * @return array|string
     */
    protected function covertUpdatedRule($key, $rules)
    {
        if (is_string($rules)) {
            $rules = explode('|', $rules);
        }

        foreach ($rules as &$rule) {
            if ($rule == 'required') {
                $rule = 'sometimes';
            }
        }
        return $rules;
    }

    /**
     * get entity create rules
     * @param null $key
     * @return array
     */
    public function getCreateRules($key = null)
    {
        return is_null($key) ? $this->propertyRules : $this->propertyRules[$key] ?? null;
    }

    /**
     * getProperties
     * @return array
     */
    public function getProperties(): array
    {
        return array_keys($this->propertyRules);
    }

    /**
     * Get the Property Array
     *
     * @return array
     */
    public function getPropertyArray(): array
    {
        return Arr::only($this->attributes, $this->getProperties());
    }

    /**
     * get the attributes for create
     * @return mixed
     */
    public function getAttributesForCreate()
    {
        $attributes = Arr::except($this->getPropertyArray(), [$this->resourceKey()]);
        $attributes['created_at'] = Carbon::now()->toDateTimeString();
        $attributes['updated_at'] = Carbon::now()->toDateTimeString();
        return $attributes;
    }

    /**
     * get the attributes for update
     * @return mixed
     */
    public function getAttributesForUpdate()
    {
        $attributes = Arr::except($this->getPropertyArray(), ['created_at']);
        $attributes['updated_at'] = Carbon::now()->toDateTimeString();
        return $attributes;
    }

    /**
     * entity init
     * you can transform array to entity here
     * your entity should implements Arrayable so you can transform to entity
     * @return mixed
     */
    public function init()
    {
        return $this;
    }

    public function toEntity()
    {
        return $this;
    }

    public function resourceKey():string
    {
        return 'id';
    }
}
