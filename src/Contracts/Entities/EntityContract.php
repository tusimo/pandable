<?php


namespace Tusimo\Pandable\Contracts\Entities;

use ArrayAccess;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

interface EntityContract extends Arrayable, ArrayAccess, Jsonable, JsonSerializable
{

}
