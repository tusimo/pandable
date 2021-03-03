<?php

namespace Tusimo\Pandable\Client;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Contracts\Support\Arrayable;
use Tusimo\Pandable\Queries\RequestClientQuery;

class Api
{

    /**
     * Supported Services
     *
     * @var Service[]
     */
    private static $services;
    /**
     * Client
     *
     * @var Client
     */
    protected $client;
    /**
     * resource name
     *
     * @var string $name
     */
    protected $name;
    protected $version = 'v1';
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $baseUri;
    /**
     * list query
     *
     * @var RequestClientQuery $query
     */
    protected $query = null;

    /**
     * Register supported service
     *
     * @param Service $service
     * @return void
     */
    public static function registerService(Service $service)
    {
        static::$services[$service->getName()] = $service;
    }

    public static function useService(string $name)
    {
        $self = new self();
        $service = static::getService($name);
        $self->setBaseUri($service->getEndpoint());
        return $self;
    }

    public static function getService(string $name): Service
    {
        return static::$services[$name];
    }

    /**
     * Get Resource From API
     *
     * @param $id
     * @return ApiResponse
     */
    public function get($id)
    {
        $uri = $this->getResourceUri($id);
        $uri .= '?' . $this->getQuery()->toUriQueryString();
        try {
            $response = $this->getClient()->get($uri);
        } catch (BadResponseException $e) {
            $response = $e->getResponse();
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }
        return new ApiResponse($response);
    }

    /**
     * Get Resource URI
     *
     * @param $id
     * @return string
     */
    public function getResourceUri($id)
    {
        return $this->getParsedUri() . '/' . $id;
    }

    /**
     * Get Parsed Uri for Api
     *
     * @return string
     */
    protected function getParsedUri()
    {
        $uri = sprintf(
            '%s/%s/%s',
            $this->baseUri,
            $this->version,
            $this->name
        );
        return $uri;
    }

    /**
     * Get Query
     *
     * @return RequestClientQuery
     */
    protected function getQuery()
    {
        if ($this->query) {
            return $this->query;
        }
        $this->query = new RequestClientQuery();
        return $this->query;
    }

    protected function getClient()
    {
        if (!$this->client) {
            $this->client = new Client([
                'connect_timeout' => 2,
                'read_timeout' => 10,
                'timeout' => 20,
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]);
        }
        return $this->client;
    }

    /**
     * Set client
     *
     * @param Client $client Client
     *
     * @return  self
     */
    public function setClient(Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * List Resource From API
     *
     * @return ApiResponse
     */
    public function list()
    {
        $uri = $this->getParsedUri();
        $uri .= '?' . $this->getQuery()->toUriQueryString();
        try {
            $response = $this->getClient()->get($uri);
        } catch (BadResponseException $e) {
            $response = $e->getResponse();
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }
        return new ApiResponse($response);
    }

    /**
     * Add Resource Via API
     *
     * @param array | Arrayable $data
     * @return ApiResponse
     */
    public function add($data)
    {
        $resourceArray = [];
        if ($data instanceof Arrayable) {
            $resourceArray = $data->toArray();
        }
        if (is_array($data)) {
            $resourceArray = $data;
        }

        try {
            $response = $this->getClient()->post(
                $this->getParsedUri(),
                [
                    'json' => $resourceArray
                ]
            );
        } catch (BadResponseException $e) {
            $response = $e->getResponse();
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }
        return new ApiResponse($response);
    }

    /**
     * Update Resource Via API
     *
     * @param $id
     * @param array| Arrayable $data
     * @return ApiResponse
     */
    public function update($id, $data)
    {
        $resourceArray = [];
        if ($data instanceof Arrayable) {
            $resourceArray = $data->toArray();
        }
        if (is_array($data)) {
            $resourceArray = $data;
        }

        try {
            $response = $this->getClient()
                ->put($this->getResourceUri($id), [
                    'json' => $resourceArray
                ]);
        } catch (BadResponseException $e) {
            $response = $e->getResponse();
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }
        return new ApiResponse($response);
    }

    /**
     * Delete Resource From API
     *
     * @param $id
     * @return ApiResponse
     */
    public function delete($id)
    {
        try {
            $response = $this->getClient()->delete($this->getResourceUri($id));
        } catch (BadResponseException $e) {
            $response = $e->getResponse();
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }
        return new ApiResponse($response);
    }

    /**
     * __Call
     *
     * @param string $method
     * @param array $parameters
     * @return void
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this->getQuery(), $method)) {
            $result = $this->getQuery()->$method(...$parameters);
            if ($result instanceof RequestClientQuery) {
                return $this;
            }
            return $result;
        }
        if (method_exists($this->getClient(), $method)) {
            $result = $this->getClient()->$method(...$parameters);
            if ($result instanceof Client) {
                return $this;
            }
            return $result;
        }
        throw new Exception('unsupported method call');
    }

    /**
     * Get the value of version
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set the value of version
     *
     * @return  self
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get the value of baseUri
     */
    public function getBaseUri()
    {
        return $this->baseUri;
    }

    /**
     * Set the value of baseUri
     *
     * @return  self
     */
    public function setBaseUri($baseUri)
    {
        $this->baseUri = $baseUri;

        return $this;
    }

    /**
     * Get $name
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set $name
     *
     * @param string $name $name
     *
     * @return  self
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    public function resource(string $name)
    {
        $this->setName($name);
        return $this;
    }
}
