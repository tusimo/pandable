<?php


namespace Tusimo\Pandable\Contracts;

use Illuminate\Contracts\Support\Arrayable;

interface IdentifierContract extends Arrayable
{
    /**
     * get identifier name
     * @return string
     */
    public function getName(): string;

    /**
     * get identifier
     * @return string
     */
    public function getIdentifier(): string;
}
