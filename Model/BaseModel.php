<?php

namespace PaperAlliance\Model;

use PaperAlliance\Config;
use PaperAlliance\ObjectSerializer;

abstract class BaseModel
{
    /**
     * @var Config
     */
    protected $config;

    protected $resourcePath = '';

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->getParams['apikey'] = $config->getAppId();
        $this->setResourcePath();
    }

    /**
     * @return mixed
     */
    abstract public function setResourcePath();

    /**
     * @return string
     */
    public function getResourcePath()
    {
        return $this->resourcePath;
    }

    /**
     * get参数
     * @var array
     */
    protected $getParams = [];

    /**
     * post参数
     * @var array
     */
    protected $postParams = [];

    /**
     * @return array
     */
    public function getGetParams()
    {
        return $this->getParams;
    }

    /**
     * @return string
     */
    public function getPostParams()
    {
        return json_encode(ObjectSerializer::sanitizeForSerialization($this->postParams));
    }

}