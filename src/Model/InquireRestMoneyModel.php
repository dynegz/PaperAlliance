<?php
namespace PaperAlliance\Model;


class InquireRestMoneyModel extends BaseModel
{
    private $nonce;
    private $sign;

    /**
     * @param mixed $nonce
     */
    public function setNonce($nonce)
    {
        $this->nonce = $nonce;
        $this->getParams['nonce'] = $nonce;
    }

    /**
     * @param mixed $sign
     */
    public function setSign($sign)
    {
        $this->sign = $sign;
        $this->getParams['sign'] = $sign;
    }

    public function setResourcePath(){
        $this->resourcePath = "/userinfo/self/restMoney";
    }
}