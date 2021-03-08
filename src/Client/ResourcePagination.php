<?php

namespace Tusimo\Pandable\Client;


class ResourcePagination
{
    /**
     * CurrentPage num
     *
     * @var int
     */
    protected $currentPage;

    /**
     * FirstPageUrl
     *
     * @var string
     */
    protected $firstPageUrl;

    /**
     * FromId
     *
     * @var int
     */
    protected $from;

    /**
     * ToId
     *
     * @var int
     */
    protected $to;

    /**
     * NextPageUrl
     *
     * @var string
     */
    protected $nextPageUrl;

    /**
     * ResourcePath
     *
     * @var string
     */
    protected $path;

    /**
     * The Num Of Resource PerPage
     *
     * @var int
     */
    protected $perPage;

    /**
     * PrevPageUrl
     *
     * @var string
     */
    protected $prevPageUrl;

    /**
     * Total Resource Number
     *
     * @var int
     */
    protected $total;

    /**
     * Last Page Number
     *
     * @var int
     */
    protected $lastPage;

    /**
     * Last Page Url
     *
     * @var string
     */
    protected $lastPageUrl;

    /**
     * ResourceCollection
     *
     * @var ResourceCollection
     */
    protected $resourceCollection;


    public function __construct(array $data)
    {
        if (isset($data['meta']['length_paginator']['current_page'])) {
            $this->currentPage = $data['meta']['length_paginator']['current_page'];
        }
        if (isset($data['meta']['length_paginator']['first_page_url'])) {
            $this->firstPageUrl = $data['meta']['length_paginator']['first_page_url'];
        }
        if (isset($data['meta']['length_paginator']['from'])) {
            $this->from = $data['meta']['length_paginator']['from'];
        }
        if (isset($data['meta']['length_paginator']['next_page_url'])) {
            $this->nextPageUrl = $data['meta']['length_paginator']['next_page_url'];
        }
        if (isset($data['meta']['length_paginator']['path'])) {
            $this->path = $data['meta']['length_paginator']['path'];
        }
        if (isset($data['meta']['length_paginator']['per_page'])) {
            $this->perPage = $data['meta']['length_paginator']['per_page'];
        }
        if (isset($data['meta']['length_paginator']['prev_page_url'])) {
            $this->prevPageUrl = $data['meta']['length_paginator']['prev_page_url'];
        }
        if (isset($data['meta']['length_paginator']['to'])) {
            $this->to = $data['meta']['length_paginator']['to'];
        }
        if (isset($data['meta']['length_paginator']['total'])) {
            $this->total = $data['meta']['length_paginator']['total'];
        }
        if (isset($data['meta']['length_paginator']['last_page_url'])) {
            $this->lastPageUrl = $data['meta']['length_paginator']['last_page_url'];
        }
        if (isset($data['meta']['length_paginator']['last_page'])) {
            $this->lastPage = $data['meta']['length_paginator']['last_page'];
        }
        $resources = [];
        if (isset($data['data'])) {
            foreach ($data['data'] as $item) {
                $resource = new Resource($item);
                $resources[$resource->getId()] = $resource;
            }
        }
        $this->resourceCollection = new ResourceCollection($resources);
    }


    /**
     * Get currentPage num
     *
     * @return  int
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * Get firstPageUrl
     *
     * @return  string
     */
    public function getFirstPageUrl()
    {
        return $this->firstPageUrl;
    }

    /**
     * Get fromId
     *
     * @return  int
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Get toId
     *
     * @return  int
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Get nextPageUrl
     *
     * @return  string
     */
    public function getNextPageUrl()
    {
        return $this->nextPageUrl;
    }

    /**
     * Get resourcePath
     *
     * @return  string
     */
    public function getPath()
    {
        return $this->path;
    }


    /**
     * Get the Num Of Resource PerPage
     *
     * @return  int
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * Get prevPageUrl
     *
     * @return  string
     */
    public function getPrevPageUrl()
    {
        return $this->prevPageUrl;
    }

    /**
     * Get resourceCollection
     *
     * @return  ResourceCollection
     */
    public function getResourceCollection()
    {
        return $this->resourceCollection;
    }

    /**
     * Get total Resource Number
     *
     * @return  int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Get last Page Number
     *
     * @return  int
     */
    public function getLastPage()
    {
        return $this->lastPage;
    }

    /**
     * Get last Page Url
     *
     * @return  string
     */
    public function getLastPageUrl()
    {
        return $this->lastPageUrl;
    }
}
