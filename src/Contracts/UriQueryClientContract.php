<?php


namespace Tusimo\Pandable\Contracts;

interface UriQueryClientContract extends QueryClientContract
{
    /**
     * covert to uri query string
     * @return string
     */
    public function toUriQueryString(): string;
}
