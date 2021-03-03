<?php

namespace Tusimo\Pandable\Client;

use Illuminate\Support\Collection;

class ResourceCollection extends Collection
{
    /**
     * If Collection has resource
     *
     * @param $id
     * @return boolean
     */
    public function hasResource($id)
    {
        return $this->has($id);
    }

    /**
     * Covert Collection Resource to object
     *
     * @param string $class
     * @return void
     */
    public function covertTo(string $class)
    {
        foreach ($this->items as $key => $item) {
            $this->items[$key] = $item->covertTo($class);
        }
        return $this;
    }
}
