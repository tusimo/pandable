<?php

namespace Tusimo\Pandable\Client;

use Exception;
use Psr\Http\Message\ResponseInterface;

class ApiResponse
{
    protected $response;

    private $originalContents = '';

    private $contents = [];

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
        $this->originalContents = $this->response->getBody()->getContents();
        $this->initContents();
    }

    private function initContents()
    {
        $contents = [];
        if ($this->getOriginalContents()) {
            try {
                $contents = \GuzzleHttp\json_decode($this->originalContents, true);
            } catch (Exception $e) {
                $contents = [];
            }
        }
        $this->contents = $contents;
    }

    /**
     * 返回原始数据
     * @return string
     */
    public function getOriginalContents(): string
    {
        return $this->originalContents ?? '';
    }

    /**
     * 获取返回内容
     * @return array
     */
    public function getContents()
    {
        return $this->contents;
    }

    public function returnSuccess()
    {
        return 'SUCCESS';
    }

    /**
     * Response to Resource
     *
     * @return Resource | null
     */
    public function toResource(): ?Resource
    {
        if ($this->isServiceSuccess()) {
            return new Resource($this->getData());
        }
        return null;
    }

    /**
     * 服务是否成功
     * @return bool
     */
    public function isServiceSuccess(): bool
    {
        return $this->getServiceStatus() >= 200 && $this->getServiceStatus() < 300;
    }

    /**
     * 获取服务状态
     * @return int
     */
    public function getServiceStatus()
    {
        return (int)($this->isStatusSuccess() ? ($this->contents['code'] ?? 200) : $this->response->getStatusCode());
    }

    /**
     * 请求是否成功
     * @return bool
     */
    public function isStatusSuccess(): bool
    {
        return $this->response->getStatusCode() >= 200 && $this->response->getStatusCode() < 300;
    }

    /**
     * 获取服务数据
     */
    public function getData()
    {
        return $this->contents['data'] ?? [];
    }

    /**
     * Response to ResourceCollection
     *
     * @return void
     */
    public function toResourceCollection()
    {
        $data = $this->getData();
        $resources = [];
        foreach ($data as $item) {
            $resource = new Resource($item);
            $resources[$resource->getId()] = $resource;
        }
        return new ResourceCollection($resources);
    }

    /**
     * Response to pagination
     *
     * @return void
     */
    public function toPagination()
    {
        return new ResourcePagination($this->getContents());
    }

    /**
     * Get Response Error
     *
     * @return void
     */
    public function getError()
    {
        return $this->isServiceSuccess() ? '' : $this->getMessage();
    }

    /**
     * 获取消息
     * @return mixed|string
     */
    public function getMessage()
    {
        return $this->contents['msg'] ?? ($this->contents['message'] ?? '');
    }
}
