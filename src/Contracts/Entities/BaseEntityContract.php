<?php


namespace Tusimo\Pandable\Contracts\Entities;

use Illuminate\Support\Carbon;

/**
 * Base entity interface
 * Interface BaseEntityContract
 * @package App\Contracts\Entities
 */
/**
 * Base entity interface
 * Interface BaseEntityContract
 * @package App\Contracts\Entities
 */
interface BaseEntityContract extends EntityContract
{
    /**
     * get id
     * @return int
     */
    public function getId(): int;

    /**
     * get created_at time
     * @return Carbon|null|string
     */
    public function getCreatedAt();

    /**
     * get updated_at time
     * @return Carbon|null|string
     */
    public function getUpdatedAt();

    /**
     * set id
     * @param int $id
     * @return $this
     */
    public function setId(int $id);

    /**
     * set created_at time
     * @param mixed $value
     * @return $this
     */
    public function setCreatedAt($value);

    /**
     * set updated_at time
     * @param mixed $value
     * @return $this
     */
    public function setUpdatedAt($value);

    /**
     * get entity array
     * @return array
     */
    public function toArray();

    /**
     * 判断是否是某个实体
     * @param $value
     * @return bool
     */
    public function isEntity($value): bool;

    /**
     * 转化为某个实体
     * @param $target
     * @return mixed
     */
    public function covertTo($target);

    /**
     * @param $key
     * @return mixed
     */
    public function isAttributeDefined($key);

    /**
     * get entity create rules
     * @param null $key
     * @return array
     */
    public function getCreateRules($key = null);

    /**
     * get entity update rules
     * @param null $key
     * @return array|string
     */
    public function getUpdatedRules($key = null);

    /**
     * get property
     * @return array
     */
    public function getProperties(): array;

    /**
     * get attributes
     * @return array
     */
    public function getAttributes();

    /**
     * get the attributes for create
     * @return mixed
     */
    public function getAttributesForCreate();

    /**
     * get the attributes for update
     * @return mixed
     */
    public function getAttributesForUpdate();

    public function getPropertyArray(): array;

    public function toEntity();

    public function resourceKey():string;
}
