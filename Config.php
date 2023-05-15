<?php
namespace PaperAlliance;

/**
 * 全局配置
 * Class Config
 * @package TaowenkejiCloud
 */
class Config
{
    /**
     * Associate string to store API key
     * @var string
     */
    private $appId="";

    /**
     * Associate string to store API secret
     * @var string
     */
    private $secretKey="";

    /**
     * @var bool
     * 远程模拟检测 服务器返回模拟检测成功的结果
     */
    protected $isFakeCheck=false;

    /**
     * @param string $appId
     */
    public function setAppId($appId)
    {
        $this->appId = $appId;
    }

    /**
     * @return string
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * @return string
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * @param string $secretKey
     */
    public function setSecretKey($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * @param bool $isFakeCheck
     */
    public function setIsFakeCheck($isFakeCheck)
    {
        $this->isFakeCheck = $isFakeCheck;
    }

    /**
     * @return bool
     */
    public function isFakeCheck()
    {
        return $this->isFakeCheck;
    }

    /**
     * 生成签名
     * @param $data
     * @return string
     */
    public function getSign($data)
    {
        return md5($data.$this->getSecretKey());
    }

}